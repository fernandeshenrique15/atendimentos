# Projeto para Validação de Disciplina

Este projeto é uma aplicação WEB para gestão de atendimentos de consultórios de profissionais de saúde, como médicos, fisioterapeutas e outros, desenvolvido para atender aos requisitos de validação de disciplina.

## Funcionalidades

### Perfil Administrador
- **Cadastro de usuários**: Nome, CPF, WhatsApp, e-mail, senha, endereço comercial (rua, número, bairro, cidade, CEP) e data do cadastro.

### Perfil Usuário
- **Login**: Autenticação com e-mail e senha.
- **Troca de senha**: Obrigatória no primeiro acesso.
- **Perfil**: Visualização e edição das informações do cadastro.
- **Agenda**: Tela inicial com FullCalendar exibindo atendimentos agendados. Clicar em um dia abre um modal com os atendimentos do dia e um botão para agendamento.
- **Cadastro de clientes (pacientes)**: Nome, CPF, WhatsApp, e-mail, senha, endereço (rua, número, bairro, cidade, CEP), data do cadastro e campo de observações.
- **Tipo de atendimento**: Descrição, valor padrão e duração padrão.
- **Cadastro de atendimentos**: Cliente, tipo de atendimento, data, horário, duração, valor, status de pagamento (Pago/Aberto) e opção de recorrência (com número de repetições).
- **Cadastro de tipo de despesa**: Descrição e frequência (aleatória, diária, mensal, anual).
- **Cadastro de despesas**: Descrição, tipo de despesa, valor, data e status de pagamento (Pago/Aberto).
- **Tela de finanças**: Filtro por período (padrão: primeiro e último dia do mês), listando receitas (pagamentos) e despesas.

## Tecnologias utilizadas
- Git
- Docker
- Laravel
- Filament
- Livewire
- Postgres

## ✅ Requisitos
- [Docker](https://www.docker.com/)
- (Opcional) [Git](https://git-scm.com/) para clonar o repositório

## Instruções de Instalação

1. **Clonar o repositório**
   ```bash
   git clone https://github.com/fernandeshenrique15/atendimentos.git
   ```

2. **Navegar para a pasta do projeto**
   ```bash
   cd atendimentos
   ```

3. **Copiar o arquivo .env**
   ```bash
   cp .env.example .env
   ```

4. **Instalar dependências**
   ```bash
    docker run --rm \
      -v $(pwd):/app \
      -w /app \
      php:8.3-cli bash -c "\
    apt-get update && \
    apt-get install -y libzip-dev libicu-dev unzip && \
    docker-php-ext-install zip intl && \
    curl -sS https://getcomposer.org/installer | php && \
    php composer.phar install"
   ```

5. **Iniciar o Docker com Laravel Sail**
   ```bash
   sudo ./vendor/bin/sail up -d
   ```
   
6. **Executar as migrações do banco de dados**
   ```bash
   ./vendor/bin/sail artisan migrate
   ```

## Acesso à aplicação
Se os arquivos de Docker não forem alterados:

- Aplicação: Disponível em http://localhost:8081
- Banco de dados: Porta 5434 com mesmos dados do .env

Perfil Administrador
- URL: http://localhost:8081/admin/login
- E-mail: admin@admin.com
- Senha: 12345678

Perfil Usuário
- URL: http://localhost:8081/user/login
- E-mail: a ser cadastrado pelo admin
- Senha: a ser cadastrado pelo admin
