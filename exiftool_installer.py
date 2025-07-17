import subprocess
import shutil
import sys
import os

def is_exiftool_installed():
    return shutil.which("exiftool") is not None

def install_exiftool():
    try:
        print("[+] Atualizando repositórios...")
        subprocess.run(["apt-get", "update"], check=True)
        
        print("[+] Instalando o ExifTool...")
        subprocess.run(["apt-get", "install", "-y", "libimage-exiftool-perl"], check=True)
        
        print("[✓] ExifTool instalado com sucesso.")
    except subprocess.CalledProcessError as e:
        print(f"[-] Erro ao tentar instalar o ExifTool: {e}")
        sys.exit(1)

def main():
    if is_exiftool_installed():
        print("[✓] ExifTool já está instalado.")
    else:
        print("[!] ExifTool não encontrado. Instalando agora...")
        install_exiftool()

if __name__ == "__main__":
    if os.geteuid() != 0:
        print("[-] Este script precisa ser executado como root.")
        print("Use: sudo python3 nome_do_arquivo.py")
        sys.exit(1)
    
    main()
