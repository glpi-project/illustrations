# illustrations

SVG illustrations for [github.com/glpi-project/glpi](glpi-project)  
Colors are customizable with CSS variables.

![Icons](./docs/pics/icons.png)

## Usage

```bash
npm install @glpi/illustrations
```

Set the colors for the icons in your CSS:

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

- svg/icons until 2024-12-17: [https://pablodomrose.com/](Pablo Domrose)