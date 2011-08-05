# sfCASGuardPlugin
This project is a small modification to sfDoctrineGuardPlugin that i put together in order to have an elegant ACL integrated with a classy SSO. This modification that allows you to relay the sfGuard authentication to a CAS server, keeping profiles, groups and permissions of sfGuard. It works by comparing the CAS username with the username in the sfGuard database and forcing the login within sfGuard after successful authentication of CAS. Of course, this means that you need the user created in CAS and in sfGuard to coexist, although the only password that matters is the CAS one. 

## Authors and contributors
* [Jonathan H. Wage](http://www.symfony-project.org/plugins/developer/jonathan-h-wage) (original author of sfGuard)
* [Klaus Silveira](http://www.klaussilveira.com) (integrated CAS with sfGuard)
* [Jeanmonod David](https://github.com/jeanmonod) (author of sfCASPlugin and the CAS utility class)

## Todo
* implement the whole thing in a more elegant way

## Using sfCASGuardPlugin
In order to install, you should follow the same steps to install sfDoctrineGuardPlugin. Just clone this GIT repository instead of the original SVN. After doing the classic steps, you need to configure your CAS server information. Modify your app.yml:

```
all:
  cas:
    server_name: 'cas.example.com'
    server_port: 443
    server_path: 'cas'
    server_cert: '/path/to/cachain.pem'
```
