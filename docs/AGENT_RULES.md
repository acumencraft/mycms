AI Agent Development Rules

1. Never create database columns without migrations.
2. Always verify column existence before using them in queries.
3. Follow Filament version installed in composer.lock.
4. Do not invent fields not present in DATABASE.md.
5. Controllers must stay thin.
6. Business logic goes into Services classes.
7. Always run diagnostics before implementing new modules.
