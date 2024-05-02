# Toolbox ACF Extended Forms
ACF Extended is a must have plugin if you're serious about your ACF development. One of the big advantages is that you can create frontend editing with improved user experience. You can create forms with better placement of the fields, styled to your own needs.

With Toolbox ACF Extended Forms you can use Twig templates to render the forms. This means you can use logic to show/hide fields based on role, logged in/out - or just about anything really - easily.

## How to use
---
To get started you obviously need to create a ACF Extended Form. Take note of the "`Form Name`", because that's something that you'll be needing.

## Update after version 0.9

Things have changed after a acfe 0.9 update came out in April 2024. THe HTML tab is gone, so what's listed below isn't correct for newer versions.

If you add the `toolbox-acfe-forms` filters listed below though everything still works as expected. But make sure to update your twig template {field:fieldname} template tags to {render:fieldname} format.

#### **HTML TAB**

Go to the HTML tab and check the "`Override Form render`" box. It's probably a good idea to enter a descriptive message in the "`HTML Form render`" field so that you or anyone else will know that the output is coming from an external plugin. Something like "Will be replaced by Toolbox ACFE Forms".

#### **SUCCESS TAB**
There's an additional message you can set, the "`Success Message`" field. Here you can also add a descriptive message like "Will be replaced by Toolbox ACFE Forms"

Adding the filters
Assuming you've activated the Twig Templates CPT in Toolbox plugin, you can now add your template(s) it. Use the Template Tags you find on the ACFE Forms Cheatcheat (https://www.acf-extended.com/features/modules/dynamic-forms/form-cheatsheet) alongside your well known Twig tags.

#### **IMPORTANT**
Now for the final and most important step, add the filters that point the form into the right direction to render the Twig template:

    add_filter( 'toolbox-acfe-forms/my-form-name' , function( $templatename ) { return 'custom-front-form.twig'; }, 10, 1 );
    add_filter( 'toolbox-acfe-forms/success/my-form-name' , function( $templatename ) { return 'custom-front-form-success-message.twig'; }, 10, 1 );

### version
|version|date|description|
|---|---|---|
|1.1.0|may 5th, 2024|acfe version 0.9 implemented other filter hook and template strings, {render:fieldname} instead of {field:fieldname}|