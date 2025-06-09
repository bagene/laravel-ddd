### File Structure
```
project
└─── app
│    └─── Commands
|         └─── *
|              └─── *Command.php
|              └─── *CommandHandler.php
|   └─── Queries
|        └─── *
|             └─── *Query.php
|             └─── *QueryHandler.php
└─── domains
│    └─── *
|         └─── Contracts
|         └─── DTO
|         └─── Http
|         └─── Models
|         └─── Repositories
|         └─── Response
|         └─── routes
└─── infrastructure
|    └─── Schema
|    └─── Services
|         └─── CommandBus
|         └─── QueryBus
|         └─── Shared
└─── tests
|    └─── Feature
|    └─── Integration
|    └─── Unit
```
