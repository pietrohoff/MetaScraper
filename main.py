import sys
import subprocess
import os

import lynx_installer
import exiftool_installer

from banner import exibir_banner

WORDLIST_PATH = "word_lists"

def validar_tipo(tipo):
    if len(tipo) == 3:  # tipo personalizado como "pdf", "jpg"
        with open(os.path.join(WORDLIST_PATH, "all.txt"), "r", encoding="utf-8") as f:
            if tipo in f.read():
                return tipo
            else:
                print("Tipo não suportado.")
                sys.exit(1)
    elif tipo == "a":
        return "all.txt"
    elif tipo == "m":
        return "medium.txt"
    elif tipo == "s":
        return "small.txt"
    else:
        print("Tipo de arquivo inválido. Use: a (all), m (medium), s (small) ou um tipo como 'pdf'.")
        sys.exit(1)

def carregar_lista(file):
    if file.endswith(".txt"):
        path = os.path.join(WORDLIST_PATH, file)
        with open(path, "r", encoding="utf-8") as f:
            return [linha.strip() for linha in f if linha.strip()]
    else:
        return [file]  # tipo único, como "pdf"

def buscar_arquivos(alvo, tipos):
    urls = []
    for tipo in tipos:
        print(f"\n🔍 Procurando arquivos do tipo: {tipo}")
        comando = (
            f'lynx --dump "https://www.google.com/search?q=site:{alvo}+filetype:{tipo}" '
            f'| grep ".{tipo}" | cut -d"=" -f2 | egrep -v "site|google" | sed "s/...$//"'
        )

        resultado = subprocess.run(comando, shell=True, text=True, capture_output=True)
        links_encontrados = resultado.stdout.strip().splitlines()

        if links_encontrados:
            urls.extend(links_encontrados)
        else:
            print("Nenhum resultado encontrado.")
    
    return urls

def analisar_metadados(caminho_arquivo, nome_arquivo):
    os.makedirs("meta_recon", exist_ok=True)
    caminho_saida_meta = os.path.join("meta_recon", f"{nome_arquivo}.txt")

    try:
        with open(caminho_saida_meta, "w") as saida:
            subprocess.run(["exiftool", caminho_arquivo], stdout=saida, stderr=subprocess.DEVNULL)
        os.chmod(caminho_saida_meta, 0o644)  # rw-r--r--
        print(f"- Metadados extraídos para: \033[34m{caminho_saida_meta}\033[0m\n")
    except Exception as e:
        print(f"- Erro ao analisar metadados de {nome_arquivo}: {e}")

def baixar_arquivo_com_wget(url, pasta_destino):
    os.makedirs(pasta_destino, exist_ok=True)

    comando = [
        "wget",
        "-P", pasta_destino,
        "--quiet",
        "--show-progress",
        "--no-check-certificate",
        url
    ]

    try:
        resultado = subprocess.run(comando, text=True, capture_output=True, check=True)
        print(f"- Arquivo baixado com sucesso: {url}")

        nome_arquivo = url.split("/")[-1]
        caminho_arquivo = os.path.join(pasta_destino, nome_arquivo)

        analisar_metadados(caminho_arquivo, nome_arquivo)

    except subprocess.CalledProcessError:
        print(f"- Arquivo não disponível ou link inválido: {url}")

def main():
    exibir_banner()

    if len(sys.argv) != 3:
        print("\n❌ Uso correto: python3 main.py <dominio> <tipo>\n")
        sys.exit(1)

    alvo = sys.argv[1]
    tipo = sys.argv[2]

    print(f"\n🌐 Alvo definido: \033[1m{alvo}\033[0m")
    print("📁 Pasta de destino: files_recon")
    print("🔍 Iniciando busca por arquivos...\n")

    tipo_validado = validar_tipo(tipo)
    lista_tipos = carregar_lista(tipo_validado)
    urls_list = buscar_arquivos(alvo, lista_tipos)

    if not urls_list:
        print("\n⚠️  Nenhum arquivo encontrado para os tipos especificados.")
        return

    print("\n" + "=" * 80)
    print(f"⬇️  Baixando \033[1m{len(urls_list)}\033[0m arquivos encontrados...\n")

    for url in urls_list:
        baixar_arquivo_com_wget(url, "files_recon")

    print("=" * 80)

    resposta = input("\n🔎 Deseja analisar os metadados agora? (s/n): ").strip().lower()
    if resposta == "s":
        os.system("python3 analise_metadados.py")
    else:
        print("🛑 Análise de metadados não executada. Encerrando.")


if __name__ == "__main__":
    main()

