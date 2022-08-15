<?php
    class Database
    {
        const PORT = 5432;
        const NAME = 'market';
        const USER = 'postgres';
        const PASS = 'postgres';
        const HOST = 'postgresql';

        private $queryType;
        private $connection;

        private $select = [];
        private $insert = [];
        private $update = [];

        public function __construct()
        {
            try
            {
                $this->connection = new PDO("pgsql:host=".self::HOST.";port=".self::PORT.";dbname=".self::NAME, self::USER, self::PASS);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            }
            catch(Exception $e)
            {
                throw new Exception("Houve um problema ao conectar com o banco de dados porque: ".$e->getMessage());
            }
        }

        public function execute()
        {
            try 
            {
                switch ($this->queryType) 
                {
                    case 'select':
                        $sql = "SELECT {$this->select["columns"]} FROM {$this->select["tables"]}";                         
                        $sql .= (isset($this->select["where"])) ? " WHERE {$this->select["where"]}" : "";
                        $sql .= (isset($this->select["orderBy"])) ? " ORDER BY {$this->select["orderBy"]}" : "";

                        return ["data" => $this->query($sql)->fetchAll(PDO::FETCH_ASSOC), "sql" => $sql];
                    break;

                    case 'insert':
                        $binds = implode(",", array_pad([], count($this->insert["values"]), "?"));
                        $sql = "INSERT INTO {$this->insert["table"]} ({$this->insert["columns"]}) VALUES({$binds}) RETURNING id";
    
                        return ["insertedRowID" => $this->query($sql, $this->insert["values"])->fetchAll(PDO::FETCH_ASSOC), "sql" => $sql];
                    break;

                    case 'update':
                        $binds = [];

                        foreach ($this->update["changes"] as $key => $value) 
                            array_push($binds, "{$key} = ?");

                        $sql = "UPDATE {$this->update["table"]} SET ".implode(",", $binds);
                        $sql .= (isset($this->update["where"])) ? " WHERE {$this->update["where"]}" : "";

                        return ["affectedRows" => $this->query($sql, array_values($this->update["changes"]))->fetchAll(), "sql" => $sql];
                    break;
                    
                    default:
                        throw new Exception("Tipo de transação é inválida ou não informada");
                    break;
                }
            }
            catch(Exception $e)
            {
                throw new Exception("Houve um problema ao montar o comando SQL porque: ".$e->getMessage());
            }
        }

        public function query($sql, $bindValues = null)
        {
            try 
            {
                $query = $this->connection->prepare($sql);

                if(!is_null($bindValues))
                    $query->execute($bindValues);
                else
                    $query->execute();
    
                return $query;
            }
            catch(Exception $e)
            {
                throw new Exception("Houve um problema ao executar o comando SQL porque: ".$e->getMessage());
            }
        }

        public function select($columns = "*")
        {
            $this->queryType = "select";

            if(is_array($columns))
            {
                if(gettype(key($columns)) == "string")
                    $columns = str_replace("=", " as ", http_build_query($columns, '', ','));
                else
                    $columns = implode(",", $columns);
            }

            $this->select["columns"] = $columns;

            return $this;
        }

        public function from($tables)
        {
            if (is_array($tables))
                $this->select["tables"] = implode(",", $tables);
            else
                $this->select["tables"] = $tables;

            return $this;
        }

        public function where($filter)
        {
            $queryType = $this->queryType;

            if(isset($filter))
            {
                if(is_array($filter))
                {
                    if(gettype(key($filter)) == "string")
                        $filter = http_build_query($filter, '', ' AND ');
                    else
                        $filter = implode(" AND ", $filter);
                }
            }
            else
            {
                $filter = "";
            }

            $this->$queryType["where"] = $filter;
            return $this;
        }

        public function orderBy($column, $type)
        {
            $this->select["orderBy"] = "{$column} {$type}";
            return $this;
        }

        public function insertInto($table, $columns)
        {
            $this->queryType = "insert";
            $this->insert["table"] = $table;

            if(isset($columns))
            {
                if(is_array($columns))
                {
                    if(gettype(key($columns)) == "string")
                        $columns = implode(",", http_build_query($columns, '', '='));
                    else
                        $columns = implode(",", $columns);
                }
            }

            $this->insert["columns"] = $columns;
            return $this;
        }

        public function values($values)
        {
            $this->insert["values"] = $values;                
            return $this;
        }

        public function update($table)
        {
            $this->queryType = "update";
            $this->update["table"] = $table;
            return $this;
        }

        public function set($changes)
        {
            $this->update["changes"] = $changes;
            return $this;
        }
    }
?>