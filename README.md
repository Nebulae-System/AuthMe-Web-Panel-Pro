# Authme Web Panel PRO
### Conecta tu servidor con tu pagina web! Visualiza tu perfil e intercambia tu skin desde cualquier dispositivo!
<br>

## Descripción del Proyecto

Este proyecto consiste en un panel web diseñado para usuarios de servidores de Minecraft. Proporciona funciones como el registro de usuarios, inicio de sesión, edición de contraseñas y vinculación de correos electrónicos a las cuentas. Además, cuenta con la capacidad de cambiar la skin del personaje gracias a la integración del plugin "SkinRestorer", que permite utilizar skins en servidores no premium.

La última actualización del panel incluye un "Wizard Config", una página que simplifica la configuración del panel sin necesidad de abrir o modificar archivos. Esta función es especialmente útil para aquellos usuarios que no tienen experiencia en PHP o programación.

## Acceso al Wizard Config

Para acceder al "Wizard Config", simplemente ingresa a la página web principal de tu proyecto: https://tusitio.com/config. Los datos de acceso predeterminados son los siguientes:

- Usuario: admin
- Contraseña: admin

Es importante recordar cambiar estos valores predeterminados una vez ingresado al sistema, ya que podrían permitir que otra persona acceda sin tu permiso.

<br>
<br>
<br>

## Requerimientos:
### - <a href="https://www.spigotmc.org/resources/authmereloaded.6269/">Authme Reloaded</a>
### - <a href="https://www.spigotmc.org/resources/skinsrestorer.2124/">Skins Restorer</a>
### - Base de Datos.

<br>
<br>
<br>

## Configuracion Authme - config.yml:
    passwordHash: BCRYPT
    
    kickNonRegistered: true

    registration:
        Enable registration on the server?
        enabled: false
