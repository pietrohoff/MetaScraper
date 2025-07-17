import subprocess
import shutil
import sys
import os

def is_lynx_installed():
    return shutil.which("lynx") is not None

def install_lynx():
    try:
        print("[+] Instalando o Lynx...")
        subprocess.run(["sudo", "apt-get", "update"], check=True)
        subprocess.run(["sudo", "apt-get", "install", "-y", "lynx"], check=True)
        print("[+] Lynx instalado com sucesso.")
    except subprocess.CalledProcessError:
        print("[-] Erro ao tentar instalar o Lynx.")
        sys.exit(1)

def main():
    if is_lynx_installed():
        print("[✓] Lynx já está instalado.")
    else:
        print("[!] Lynx não encontrado.")
        install_lynx()

if __name__ == "__main__":
    if os.geteuid() != 0:
        print("Este script precisa ser executado como root ou com sudo.")
        print("Exemplo: sudo python3 check_install_lynx.py")
        sys.exit(1)
    main()
