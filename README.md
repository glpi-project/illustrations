# GLPI illustrations

Collections of SVG assets made by GLPI team for various projects.

## Scenes

**SVG illustrations** from [glpi-project.org](https://glpi-project.org) website

![Working people](./svg/scenes/working_people/WORKSPACE.svg)

## Icons

**SVG icons** for [github.com/glpi-project/glpi](glpi-project) application.  
They have been made mainly for the new service catalog of 11.0 version.  


![Icons](./docs/pics/icons.png)

### Usage

```bash
npm install @glpi-project/illustrations
```

Most icons have their colors customizable with CSS variables.  
So, set the colors for the icons in your CSS:

```css
:root {
    --glpi-illustrations-background: #FFFFFF;
    --glpi-illustrations-header-dark: #2F3F64;
    --glpi-illustrations-header-light: #BCC5DC;
    --glpi-illustrations-primary: #FEC95C;
}
```

Add an icon on your page with the following markup:

```html
<svg width="24" height="24">
  <use xlink:href="path/to/glpi-illustrations.svg#approve-requests" />
</svg>
```

## License


This work is licensed under a
[Creative Commons Attribution 4.0 International License][cc-by-sa].

[![CC BY SA 4.0][cc-by-sa-image]][cc-by-sa]

[cc-by-sa]: https://creativecommons.org/licenses/by-sa/4.0/
[cc-by-sa-image]: https://licensebuttons.net/l/by-sa/4.0/88x31.png

## Credits

[Pablo Domrose](https://pablodomrose.com/):

- svg/icons
- svg/scenes/default
- svg/scenes/gradient

[Vincent Batard](https://www.vincent-batard.fr/):

- svg/brushes
- svg/scenes/working_people
