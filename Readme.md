# UI Hook Demo

Shows various ways of how the UI of ILIAS can be extended by the User Interface Hook Plugins.

## Install 
1. Place the code of this plugin into: `Customizing/global/plugins/Services/UIComponent/UserInterfaceHook/UIHookDemo`
 Note that the name of the folder is case sensitive.
2. Navigate to Admininistration > Plugins to install and activate to plugin

## Usage
You can see different options of how to manipulate to ILIAS UI at work here by adding the following Get-Params to your URL:
* UIDemo=addTab: Shows a new tab added by modify GUI
* UIDemo=newMetabarByGetHtml: Replaces the Metabar of ILIAS by Using getHTML
* UIDemo=JsonRenderer: A rather ruthless way to render parts of the page as json
* UIDemo=CustomMetaBar: Add a new Item the the Main Bar of ILIAS (aka Main Menu)
* UIDemo=CustomMainMenuEntry: Add a new main menu entry statically.

There is also an advanced demo of how the Main Menu can be extended by using the new Global Screen service. The
extension adds top items that can be shown if a set of global roles is attached to the current user. You can see this
additional type in the Administration > Main Menu by adding a new Top Item.

