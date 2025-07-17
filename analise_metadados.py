import os
import re

META_RECON_PATH = "meta_recon"

# Campos de interesse para investigação
CAMPOS_RELEVANTES = [
    "File Name",
    "File Size",
    "File Type",
    "MIME Type",
    "Application",
    "Company",
    "Creator",
    "Last Modified By",
    "Create Date",
    "Modify Date",
    "File Modification Date/Time",
    "App Version"
]

def extrair_metadados(caminho_arquivo):
    dados = {}
    with open(caminho_arquivo, "r", encoding="utf-8", errors="ignore") as f:
        for linha in f:
            # Remove espaços à esquerda/direita e ignora linhas vazias
            linha = linha.strip()
            if not linha:
                continue

            # Quebra em duas partes: chave + valor baseado em 2+ espaços
            partes = re.split(r'\s{2,}', linha, maxsplit=1)
            if len(partes) == 2:
                chave, valor = partes
                if chave in CAMPOS_RELEVANTES:
                    dados[chave] = valor.strip()

    return dados

    dados = {}
    with open(caminho_arquivo, "r", encoding="utf-8", errors="ignore") as f:
        for linha in f:
            linha = linha.strip()
            for campo in CAMPOS_RELEVANTES:
                if linha.startswith(campo + " :"):
                    chave, valor = linha.split(":", 1)
                    dados[chave.strip()] = valor.strip()
    return dados

def mostrar_analise(dados):
    print("\n" + "="*80)
    print(f"📂 Análise do arquivo: {dados.get('File Name', 'Desconhecido')}")
    print("="*80)
    print(f"📄 Tipo de Arquivo   : {dados.get('File Type', '-')}")
    print(f"📦 Tamanho           : {dados.get('File Size', '-')}")
    print(f"🕓 Criado em         : {dados.get('Create Date', '-')}")
    print(f"🛠️  Modificado em     : {dados.get('Modify Date', '-')}")
    print(f"🧠 Criador           : {dados.get('Creator', '-')}")
    print(f"✍️  Último que editou : {dados.get('Last Modified By', '-')}")
    print(f"🏢 Empresa           : {dados.get('Company', '-')}")
    print(f"🖥️  Aplicativo usado  : {dados.get('Application', '-')}")
    print(f"🧬 Versão App        : {dados.get('App Version', '-')}")
    print(f"🔖 MIME Type         : {dados.get('MIME Type', '-')}")
    print(f"🕒 Mod. no Sistema   : {dados.get('File Modification Date/Time', '-')}")
    print("="*80)

def main():
    if not os.path.isdir(META_RECON_PATH):
        print(f"❌ A pasta '{META_RECON_PATH}' não existe.")
        return

    arquivos = [f for f in os.listdir(META_RECON_PATH) if f.endswith(".txt")]

    if not arquivos:
        print("❌ Nenhum arquivo de metadados encontrado em meta_recon/")
        return

    for arquivo in arquivos:
        caminho = os.path.join(META_RECON_PATH, arquivo)
        dados = extrair_metadados(caminho)
        mostrar_analise(dados)

if __name__ == "__main__":
    main()
