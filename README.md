# PHP_MVC_Camagru
First PHP project. With gallery, bad front-end part and not bad back-end part(i think so) 

The Camagru Project
Subject

This web project is challenging you to create a small web application allowing to make
basic video editing using your webcam and some predefined images.

A user of your web app will need to be able to select an image in a list of superposable
images (for instance a picture frame, or other “we don’t wanna know what you are using
this for” objects), take a picture with his/her webcam and admire the result that should
be mixing both pictures.
All captured images should be public, likeables and commentable.
When you say top site you say top language. You will be forced to use PHP to create this
project.
You are not authorized to use any framework, micro-framework, librairies or anything
from the outside world (except for fonts), neither for the client not for the server side.
So this means no Bootstrap, no jQuery, no Symfony, etc... Only the PHP installed extensions
(GD and SGBD drivers, among others) and the native Javascript APIs of your
browser are allowed.
You will have to use the abstraction interface PDO1
to accessyour database and define
the error mode2 on PDO::ERRMODE_EXCEPTION.
You can use the web server of your choice, either Apache, Nginx or even built-in
web server3
.
Your web application should be at list be compatible with Firefox (>= 41) and
Chrome (>= 46).
Your website should have a decent page layout (meaning at least a header, a main
section and a footer), able to display on mobile devices and have an adapted layout on
small resolutions.
All your forms should have correct validations and the whole site should be secured.
This point is COMPULSORY and shall be verified when the project is evaluated. To
have an idea, here are some stuff that is NOT considered as SECURE:
• Store plain (unencrypted) passwords in the database.
• Offer the ability to inject HTML ou “user” JavaScript in badly protected variables.
• Offer the ability to upload undesired content on the server.
• Offer the possibility of altering an SQL query.

Requirements
You will develop a web application. Even if this is not required, try to structure your
application (in MVC for instance). Your application should have the following features:
IV.1 User features
• The application should allow a user to sign up by asking at least for an email, a
password with at least a minimum level of complexity. At the end of the sign-up
process a confirmation email should ve sent to the user in order to validate the
sign-up process.
• The user should then be able to connect using his username and his password. This
user also should be able to receive an email for resetting his password in case he
forgot it.
• The user should be able to disconnect in one click at any time on any page.
5
Web The Camagru Project
IV.2 Editing features
This part should be accessible only to users that are authentified/connected and gently
reject all other users that attempt to access it without being successfully logged in.
This page should contain 2 sections:
• A main section containing the preview of the user’s webcam, the list of superposable
images and a button allowing to capture a picture.
• A side section displaying thumbnails of all previous pictures taken.
• Superposable images must be selectable and the button allowing to take the picture
should be inactive (not clickable) as long as no superposable image has been
selected.
• The creation of the final image (so among others the superposing of the two images)
must be done on the server side, in PHP.
• Because not everyone has a webcam, you should allow the upload of a user image
instead of capturing one with the webcam.
6
Web The Camagru Project
• The user should be able to delete his edited images, but only his, not other users’
creations.
IV.3 Gallery features
• This part is to be public and must display all the images edited by all the users,
ordered by date of creation. It should also allow (only) a connected user to like
them and/or comment them.
• When an image receives a new comment, the author of the image should be notified
by email.
• The list of images must be presented in successive pages (i.e. X images by page).
