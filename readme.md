Display Suite
=============

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/tedslittlerobot/display-suite/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/tedslittlerobot/display-suite/?branch=master)

Display utilities for Laravel V.

There are two parts to this package (click each one for more details):

- [Assets](docs/assets/readme.md)
- [Components](docs/components/readme.md)

### Development

Yes, this is currently limited to laravel 5. The vast majority of it doesn't actually require laravel at all, and i will eventually remove it as a dependancy.

Super basic roadmap:

- [x] scripts
- [x] styles
- [x] components
- [ ] use "after" middleware to replace the required source list with the final source list or compiled sources
- [ ] add option to inject assets, rather than load via http
- [ ] validation on components (required values, etc.)
- [ ] use a tidier way of calling things (like facades or blade tags instead of app('deps') calls)
- [ ] recursive component wrapping
- [ ] allow multiple "active" sources
- [ ] svg ( put into symbols - https://github.com/jkphl/svg-sprite / https://github.com/w0rm/gulp-svgstore, inject into head, or link to import )
- [ ] images ( imagemin, sprites? )
- [ ] fonts ( is there something useful we can do with fonts? )
