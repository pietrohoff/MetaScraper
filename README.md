
```bash

███    ███ ███████ ████████  █████  ███████  ██████ ██████   █████  ██████  ███████ ██████  
████  ████ ██         ██    ██   ██ ██      ██      ██   ██ ██   ██ ██   ██ ██      ██   ██ 
██ ████ ██ █████      ██    ███████ ███████ ██      ██████  ███████ ██████  █████   ██████  
██  ██  ██ ██         ██    ██   ██      ██ ██      ██   ██ ██   ██ ██      ██      ██   ██ 
██      ██ ███████    ██    ██   ██ ███████  ██████ ██   ██ ██   ██ ██      ███████ ██   ██ 


```                                               

MetaScraper é uma ferramenta em PHP para baixar imagens e arquivos de um site, analisar seus metadados e retornar informações relevantes.

## Funcionalidades

- Baixa imagens de uma URL fornecida.
- Analisa metadados de imagens, como dados EXIF.
- Exclui automaticamente arquivos que não contêm dados ou que não foram baixados corretamente.
- Mostra no terminal apenas os arquivos que contêm metadados relevantes.

## Requisitos

- **PHP 7.4** ou superior
- **cURL** habilitado no PHP
- Servidor **Apache** (se usar o Docker, o ambiente já está configurado)
  
## Instalação

### Clonando o Repositório

1. Clone o repositório para o seu ambiente local:

   ```bash
   git clone https://github.com/pietrohoff/MetaScraper.git
   cd MetaScraper
   ```

2. Crie o diretório de `downloads` (caso ele ainda não exista):

   ```bash
   mkdir downloads
   ```

3. (Opcional) Instale dependências adicionais com o Composer (caso aplicável):

   ```bash
   composer install
   ```

### Usando Docker (Recomendado)

Se você preferir rodar o projeto em um ambiente Docker, siga as instruções abaixo.

1. **Configuração do Docker**:
   O projeto inclui um arquivo `docker-compose.yml` configurado com PHP 8.1 e Apache. Para iniciar o ambiente:

   ```bash
   docker-compose up -d
   ```

2. **Acessar o Terminal**:
   Para acessar o terminal do container e rodar o projeto:

   ```bash
   docker exec -it MetaScraper bash
   ```

3. **Rodar o Projeto**:
   No terminal do container ou em seu ambiente local, execute o seguinte comando:

   ```bash
   php index.php
   ```

   O script solicitará uma URL para análise.

## Executando o Projeto

1. No terminal, execute o comando:

   ```bash
   php index.php
   ```

2. O sistema solicitará que você insira a URL do site para fazer o download das imagens e arquivos. Digite a URL e pressione Enter.

3. O script irá:
   - Baixar as imagens encontradas na URL fornecida.
   - Exibir os metadados relevantes no terminal.
   - Excluir automaticamente os arquivos que estejam vazios ou sem metadados.

## Estrutura do Projeto

```
/MetaScraper
│
├── /src
│   ├── Download.php           # Gerencia o download de conteúdo
│   ├── Extractor.php          # Extrai links de imagens e arquivos
│   ├── MetaDataAnalyzer.php   # Analisa os metadados das imagens
│   ├── Main.php               # Controla o fluxo principal do script
│
├── /downloads                 # Diretório onde os arquivos baixados são salvos (ignorado pelo Git)
│
├── /logs                      # Diretório para armazenar logs (ignorado pelo Git)
│
├── /vendor                    # Dependências de terceiros (ignorado pelo Git)
│
├── docker-compose.yml          # Configuração do ambiente Docker
├── .gitignore                 # Arquivo de configuração para ignorar pastas no Git
├── config.php                 # Configurações gerais do projeto
├── index.php                  # Ponto de entrada do script
└── README.md                  # Documentação do projeto
```

## Contribuição

1. Faça um fork do projeto.
2. Crie uma branch com suas alterações:

   ```bash
   git checkout -b minha-feature
   ```

3. Commit suas mudanças:

   ```bash
   git commit -m "Adiciona nova funcionalidade"
   ```

4. Envie para o repositório original:

   ```bash
   git push origin minha-feature
   ```

5. Abra um Pull Request para revisão.

## Licença

Este projeto está sob a licença MIT. Consulte o arquivo [LICENSE](LICENSE) para mais informações.
