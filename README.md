```bash
███    ███ ███████ ████████  █████  ███████  ██████ ██████   █████  ██████  ███████ ██████  
████  ████ ██         ██    ██   ██ ██      ██      ██   ██ ██   ██ ██   ██ ██      ██   ██ 
██ ████ ██ █████      ██    ███████ ███████ ██      ██████  ███████ ██████  █████   ██████  
██  ██  ██ ██         ██    ██   ██      ██ ██      ██   ██ ██   ██ ██      ██      ██   ██ 
██      ██ ███████    ██    ██   ██ ███████  ██████ ██   ██ ██   ██ ██      ███████ ██   ██ 
```

# MetaScraper

**MetaScraper** é uma ferramenta em Python para busca, download e análise de arquivos públicos encontrados em sites. Ele usa `lynx` e `wget` para encontrar arquivos de tipos específicos (como PDF, DOCX, JPG etc.) e `exiftool` para extrair seus metadados.

---

## ⚙️ Funcionalidades

- Busca arquivos públicos usando Google Search (`site:<domínio> filetype:<tipo>`).
- Faz download de todos os arquivos encontrados com `wget`.
- Executa `exiftool` para extrair metadados dos arquivos.
- Salva os arquivos baixados em `files_recon/` e os metadados em `meta_recon/`.
- Ignora arquivos já ignorados pelo `.gitignore`.

---

## 🧰 Requisitos

- Python 3.6+
- [`lynx`](https://lynx.browser.org/)
- [`wget`](https://www.gnu.org/software/wget/)
- [`exiftool`](https://exiftool.org/)
- Linux (recomendado)

Você pode instalar as dependências com:

```bash
sudo apt update
sudo apt install lynx wget libimage-exiftool-perl -y
```

---

## 🚀 Instalação

### Clonando o Repositório

```bash
git clone https://github.com/pietrohoff/MetaScraper.git
cd MetaScraper
```

---

## ▶️ Executando

```bash
python3 main.py <domínio> <tipo>
```

### Exemplos:

```bash
python3 main.py interquimica.com.br pdf
python3 main.py exemplo.com jpg
```

- Tipos disponíveis:
  - `a`: all.txt
  - `m`: medium.txt
  - `s`: small.txt
  - Ou diretamente `pdf`, `jpg`, `docx` etc.

Os arquivos serão salvos em:
- `files_recon/` → arquivos baixados
- `meta_recon/` → metadados extraídos com `exiftool`

---

## 📁 Estrutura do Projeto

```
/MetaScraper
├── main.py                  # Script principal
├── lynx_installer.py        # Verifica e instala o lynx
├── exiftool_installer.py    # Verifica e instala o exiftool
├── word_lists/
│   ├── all.txt
│   ├── medium.txt
│   └── small.txt
├── files_recon/             # Arquivos baixados (ignorado pelo Git)
├── meta_recon/              # Metadados extraídos (ignorado pelo Git)
└── .gitignore               # Define o que não será versionado
```

---

## 🧼 Limpando os diretórios (opcional)

Para apagar os resultados:

```bash
rm -rf files_recon/*
rm -rf meta_recon/*
```

Evite rodar o script como `sudo`, pois os arquivos ficarão com permissões de root.

---

## 🤝 Contribuição

1. Faça um fork do projeto
2. Crie uma branch:
   ```bash
   git checkout -b minha-feature
   ```
3. Commit:
   ```bash
   git commit -m "Adiciona nova feature"
   ```
4. Push:
   ```bash
   git push origin minha-feature
   ```
5. Abra um Pull Request

---

## 📄 Licença

Este projeto está sob a licença MIT. Consulte o arquivo [LICENSE](LICENSE) para mais informações.
