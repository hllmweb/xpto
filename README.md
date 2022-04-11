# XPTO 

## Agendador de URL que verifica a cada 1 minuto as URLS'S cadastradas



## Caso de Uso – Validação de URLs
## 5 Contextualização

A Empresa XPTO faz o rastreamento de status de websites. Seus clientes podem acessar a esta aplicação web para cadastrar as URLs que desejam rastrear.

Ao cadastrar uma nova URL o cliente apenas recebe uma confirmação de que a URL foi cadastrada com sucesso, além de poder visualizá-la na sua lista de URLs cadastradas. A cada 1 minuto, o robô desta aplicação (que nada mais é do que um script executado de forma agendada através de cron ou job), irá consultar todas as URLs cadastradas.

O robô irá armazenar o código de status HTTP e o corpo da resposta, de forma que o cliente saiba quando sua URL foi acessada, qual foi o status code retornado, bem c\isualizar o corpo do HTML retornado.

## 6 Implementação

O candidato deve implementar um sistema que permita acesso por url através de um browser.
Após se cadastrar, o usuário poderá adicionar URLs e visualizar uma lista de urls cadastradas e um link para visualizar a resposta das requisições;

O sistema terá uma tabela no banco de dados para armazenar a URL, a resposta das requisição HTTP, 'status code' da resposta, e o timestamp do momento da consulta. 

## 6.1 Regras:

● Somente usuários cadastrados e autenticados podem cadastrar URLs e visualizar o resultado das URLs previamente cadastradas;

● O formulário de cadastro de URL deve ter uma validação simples, para que a string informada no campo tenha o formato de uma URL;

● O painel de visualização das URLs deve ter um mecanismo de refresh (estilo ajax sem recarregar a página toda) para acompanhar atualizações de status das URLs;

● O candidato pode implementar da maneira que julgar necessário um agendador que dispare a cada 1 minuto o comando para verificar URLs cadastradas através de uma cron/crontab, job, Laravel Queues, Amazon SQS, RabbitMQ, ou outro agendador que preferir;

Obrigada!