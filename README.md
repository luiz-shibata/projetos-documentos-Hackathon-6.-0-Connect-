# Sistema de Documentos - Cresol

Sistema completo para gestão de pessoas e documentos desenvolvido em Laravel com AdminLTE.

## 📋 Características

- **Framework**: Laravel 12
- **Interface**: AdminLTE 3 com Bootstrap (sem Vue/React)
- **Banco de Dados**: MySQL
- **Autenticação**: Não implementada (acesso direto)
- **Upload**: Documentos armazenados como binário no banco

## 🚀 Funcionalidades

### Gestão de Pessoas
- ✅ Cadastro completo de pessoas
- ✅ Campos: Nome, Documento, E-mail, Celular/WhatsApp
- ✅ Validação de unicidade para documento e e-mail
- ✅ CRUD completo (Create, Read, Update, Delete)
- ✅ Interface responsiva

### Gestão de Documentos
- ✅ Upload e armazenamento de documentos
- ✅ Vinculação com pessoas
- ✅ Tipos: Pessoal ou Financeiro
- ✅ Download de documentos
- ✅ Visualização de detalhes
- ✅ CRUD completo

## 🛠 Instalação e Configuração

### Pré-requisitos
- PHP 8.2+
- Composer
- MySQL
- Servidor web (Apache/Nginx) ou usar `php artisan serve`

### Configuração do Banco de Dados
1. Criar banco de dados MySQL com o nome: `documentos_cresol`
2. Configurar usuário MySQL: `WEBLINE` com senha: `*bew0715`

### Passos de Instalação

1. **Clone ou navegue até o projeto**
   ```bash
   cd d:\novoprojeto\documentos-cresol
   ```

2. **Instalar dependências**
   ```bash
   composer install
   ```

3. **Configurar ambiente**
   - O arquivo `.env` já está configurado com as credenciais do banco
   - Verificar se as configurações do banco estão corretas

4. **Executar migrações**
   ```bash
   php artisan migrate
   ```

5. **Instalar AdminLTE (já configurado)**
   ```bash
   php artisan adminlte:install
   ```

6. **Iniciar servidor**
   ```bash
   php artisan serve
   ```

7. **Acessar aplicação**
   - URL: http://127.0.0.1:8000
   - Redirecionamento automático para lista de pessoas

## 📁 Estrutura do Projeto

```
documentos-cresol/
├── app/
│   ├── Http/Controllers/
│   │   ├── PessoaController.php     # CRUD de pessoas
│   │   └── DocumentoController.php  # CRUD de documentos
│   └── Models/
│       ├── Pessoa.php               # Model Pessoa
│       └── Documento.php            # Model Documento
├── database/
│   └── migrations/
│       ├── create_pessoas_table.php
│       └── create_documentos_table.php
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php            # Layout base AdminLTE
│   ├── pessoas/                     # Views de pessoas
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   └── show.blade.php
│   └── documentos/                  # Views de documentos
│       ├── index.blade.php
│       ├── create.blade.php
│       ├── edit.blade.php
│       └── show.blade.php
├── routes/
│   └── web.php                      # Rotas da aplicação
└── public/css/
    └── admin_custom.css             # Estilos customizados
```

## 🗄 Estrutura do Banco de Dados

### Tabela `pessoas`
- `id` - Primary Key
- `nome` - String (obrigatório)
- `documento` - String (único, obrigatório)
- `email` - String (único, obrigatório)
- `celular_whatsapp` - String (obrigatório)
- `created_at` / `updated_at` - Timestamps

### Tabela `documentos`
- `id` - Primary Key
- `pessoa_id` - Foreign Key (pessoas.id)
- `nome` - String (obrigatório)
- `tipo` - Enum: 'pessoal' ou 'financeiro'
- `tipo_arquivo` - String (MIME type)
- `nome_original` - String (nome original do arquivo)
- `conteudo_binario` - LongText (arquivo em base64)
- `created_at` / `updated_at` - Timestamps

## 🎨 Interface

### Layout AdminLTE
- Menu lateral com navegação
- Área de conteúdo principal
- Cards responsivos
- Botões de ação intuitivos
- Alertas de feedback
- Tabelas com paginação

### Navegação
- **Dashboard**: Lista de pessoas (página inicial)
- **Pessoas**: Gestão completa de pessoas
- **Documentos**: Gestão completa de documentos

## 🔧 Funcionalidades Técnicas

### Upload de Arquivos
- Limite: 10MB por arquivo
- Armazenamento: Base64 no banco de dados
- Tipos aceitos: Todos os tipos de arquivo
- Download: Restauração do arquivo original

### Validações
- Nome: Obrigatório, máximo 255 caracteres
- Documento: Obrigatório, único
- E-mail: Obrigatório, formato válido, único
- Celular: Obrigatório
- Arquivo: Obrigatório no cadastro, máximo 10MB

### Relacionamentos
- Uma pessoa pode ter múltiplos documentos
- Um documento pertence a uma pessoa
- Exclusão em cascata (pessoa excluída = documentos excluídos)

## 🌐 Rotas Disponíveis

### Pessoas
- `GET /` - Redireciona para lista de pessoas
- `GET /pessoas` - Lista todas as pessoas
- `GET /pessoas/create` - Formulário de nova pessoa
- `POST /pessoas` - Salva nova pessoa
- `GET /pessoas/{id}` - Detalhes da pessoa
- `GET /pessoas/{id}/edit` - Formulário de edição
- `PUT /pessoas/{id}` - Atualiza pessoa
- `DELETE /pessoas/{id}` - Remove pessoa

### Documentos
- `GET /documentos` - Lista todos os documentos
- `GET /documentos/create` - Formulário de novo documento
- `POST /documentos` - Salva novo documento
- `GET /documentos/{id}` - Detalhes do documento
- `GET /documentos/{id}/edit` - Formulário de edição
- `PUT /documentos/{id}` - Atualiza documento
- `DELETE /documentos/{id}` - Remove documento
- `GET /documentos/{id}/download` - Download do arquivo

## 🔒 Configurações de Segurança

### Validações
- CSRF protection habilitado
- Validação server-side em todos os formulários
- Sanitização de dados de entrada

### Banco de Dados
- Relacionamentos com integridade referencial
- Constraints de unicidade
- Exclusão em cascata configurada

## 📊 Configuração AdminLTE

- Título: "Sistema Documentos Cresol"
- Logo: "Documentos Cresol"
- Tema: Dark sidebar com primary color
- Menu estruturado por funcionalidade

## 🎯 Para Iniciar o Sistema

1. **Navegue até o diretório:**
   ```bash
   cd d:\novoprojeto\documentos-cresol
   ```

2. **Inicie o servidor:**
   ```bash
   php artisan serve
   ```

3. **Acesse:** http://127.0.0.1:8000

**Sistema pronto para uso!** 🚀

---

**Desenvolvido para Cresol** | Sistema de Gestão de Documentos | Laravel + AdminLTE
