#!/bin/bash

user=$1
secret=$2

echo "Usuario informado: $user"
echo "Senha informada: $secret"
check=$(grep -w $user ./voicemail.conf | cut -d'>' -f 1,2 | grep -w $secret -c)

if [ "$check" -eq  "0" ]; then
	echo "Login incorreto"
else
	echo "Login OK!"
fi
