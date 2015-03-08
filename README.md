# codeigniter

Scaffolding for codeigniter based application. It uses codeigniter/framework and TankAuth/Tank-Auth library.
Adaptations:
- file structure changed (system folder in vendor, application out of web docroot for httpd)
- tank_auth adapted to postgesql, role field added 
- lang class extended to read txt files
- model class extended to having common get methods
- router class extended to handling controller-action name schema
- controller class extended to control authorization access and view settings

Added:
- permission library
- auth user helper
- hooks for permission and additional debug

Using guide to be added...
