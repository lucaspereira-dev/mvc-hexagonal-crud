#!/bin/bash

# Execute esse script caso queria excluir todas as informações que são geradas ao subir o contianer (IMPORTANTE: Não é limitado a apenas containers desse projeto)

# Excluir contêineres
if [ "$(docker container ls -a -q)" ]; then
    echo "Excluindo contêineres"
    docker container rm -f $(docker container ls -a -q)
else
    echo "Sem contêineres para excluir"
fi

# Excluir imagens
if [ "$(docker image ls -a -q)" ]; then
    echo "Excluindo imagens"
    docker image rm -f $(docker image ls -a -q)
else
    echo "Sem imagens para excluir"
fi

# Excluir volumes
if [ "$(docker volume ls -q)" ]; then
    echo "Excluindo volumes"
    docker volume rm -f $(docker volume ls -q)
else
    echo "Sem volumes para excluir"
fi

# Limpando volumes não utilizados
docker volume prune -f

# Excluindo arquivos de cache
if [ -e .mysql ] || [ -e .phpunit ] || [ -e .phpunit.cache ] || [ -d vendor ]; then
    echo "Excluindo arquivos de cache"
    rm -rf .mysql .phpunit .phpunit.cache vendor composer.lock
else
    echo "Sem arquivos de cache para excluir"
fi
