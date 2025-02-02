# Utiliser une image de base Python
FROM python:3.9-slim

# Définir le répertoire de travail
WORKDIR /app
	
# Installer mkdocs et le plugin Material pour MkDocs
RUN pip install mkdocs-material

# Exposer le port 8000
EXPOSE 8000

# Définir le volume pour monter le dossier local mkdocs
VOLUME /app

# Commande par défaut pour démarrer MkDocs
CMD ["mkdocs", "serve", "--dev-addr=0.0.0.0:8000"]

# docker build -t mkdocs-image .

# docker run -p 8914:8000 mkdocs-image
# docker run -p 8914:8000 -v ./mkdocs:/app mkdocs-image
# docker run -p 8914:8000 -v C:/Users/ychampclaux/Desktop/mymkdock/mkdocs:/app mkdocs-image