# Genesis Boilerplate
Genesis boilerplate is a starter kit for Genesis child themes. It uses the most common CSS and PHP functions I find myself using when creating new themes.

The repo is setup with `/dev` directory and a gulpfile if you want to use [Gulp](http://gulpjs.com/). The `/dev` directory is where your Sass and pre processed JavaScript will live. If you prefer not to use Sass or Gulp, you'll need to manually move all the CSS from the .scss files to a styles.css file in the root directory.

(A blog post is coming on my process for building child themes which should help explain this process.)

I've used Skeleton CSS as a base, although many changes have been made to the original. Check out <http://getskeleton.com> for documentation and details about the Skeleton CSS framework.

For the Genesis Framework, check out <http://studiopress.com> for documentation and details.

## Getting Started

To start your new child theme with Genesis Boilerplate, you can [Download the files from GitHub](https://github.com/bradonomics/genesis-boilerplate/archive/master.zip) (or clone the repo: `git clone https://github.com/bradonomics/genesis-boilerplate.git`). You can then upload the files under Appearances -> Themes in your Wordpress Dashboard, although you'll probably want to add some styles before you do. Remember this is a starting point for a custom theme and pretty vanilla as is. If it doesn't make it into 90% of my custom theme work, it isn't in the boilerplate.

### What's in the download?

The download includes a rewrite of [Skeleton CSS](http://getskeleton.com) to use standard Genesis classes, and a functions file to get you started building a custom Genesis child theme.

If you're working with a designer there are also HTML samples so the designer will know what CSS classes to use and have an HTML template.

You'll want to add a [screenshot.png file](http://codex.wordpress.org/Theme_Development#Screenshot) so something will show in the Wordpress Dashboard. After this, zip the styles.css, funtions.php with these files and directories and upload the new theme to Wordpress. (If you don't have Genesis installed, this upload won't work. Check the documentation on [StudioPress.com](http://studiopress.com) for more info.)

## License

[Skeleton](https://github.com/dhg/Skeleton/blob/master/LICENSE.md) is released under the open-source MIT license. The Genesis Framework itself and [Genesis Boilerplate](https://github.com/bradonomics/genesis-boilerplate/blob/master/LICENSE.md) are released under the [GPL-2.0 License](http://www.gnu.org/licenses/gpl-2.0.html).

> This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

> This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

> You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

## Acknowledgments

Skeleton was created by [Dave Gamache](https://twitter.com/dhg).

Genesis was created by [Brian Gardner](https://twitter.com/bgardner).

Genesis Boilerplate was created by [Brad West](http://bradonomics.com/).
