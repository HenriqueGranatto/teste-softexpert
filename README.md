### Objetivo
O arquivo com a descrição completa do teste encontra-se no repositório, mas de maneira resumida o objetivo era desenvolver um sistema para mercado com os seguintes requisitos:
* Cadastro dos produtos;
* Cadastro dos tipos de cada produto;
* Cadastro dos valores percentuais de imposto dos tipos de produtos;
* A tela de venda, onde serão informados os produtos e quantidades adquiridas;
* O sistema deve apresentar o valor de cada item multiplicado pela quantidade adquirida e a quantidade pago de imposto em cada item, um totalizador do valor da compra e um totalizador do valor dos impostos;
* A venda deverá ser salva;

### Requisitos para instalação
- Git;
- Docker e Docker Compose (ou instalar em ambiente Linux).

### Instalação
1. Caso você já tenha o git e o Docker instalado, rode o seguinte comando:
```
git clone https://github.com/HenriqueGranatto/teste-softexpert.git
cd teste-softexpert/docker
docker-compose up
```
2. Caso você já tenha o git e está instalando no Ubuntu
```
git clone https://github.com/HenriqueGranatto/teste-softexpert.git
cd teste-softexpert
bash stack-deploy.sh
```

### Live server
- Uma versão de teste do sistema se encontra disponível no seguinte link (se você está lendo isso a mais de uma semana da criação do repositório esse servidor não está mais disponível)
- http://ec2-15-228-254-161.sa-east-1.compute.amazonaws.com/

### Entregáveis
- Além do código, consta no repositório a collection do Postman para o backend e uma mini modelagem do banco de dados.
