# Instagram Feed for WordPress

Display instagram photos of any user. Works **without Access Token**!

> This plugin is based on [this PHP Library](https://github.com/pgrimaud/instagram-user-feed).

## Requirement

- PHP version 7.x
- WordPress version 4.9.x

## Shortcode

```
[instafeed username="..." items-per-slide="4/3/2"]
```

Display a slider containing latest 20 photos of specific user.

- **username** (string)

- **items-per-slide** (string) - *Optional*. Amount of photos per slide. Default value is `4/3/2` which mean 4 items on desktop, 3 items on medium screen (< 767px) and 2 items on small screen (< 480px)

**NOTE**: Show by Hashtag and Load-More functions is on progress...

-----

## Custom Code

If you want to show the photos with custom markup, you can get the raw JSON data with this function:

```
$data = INSTAFEED::get( $username, <$endcursor> );
```

- **$username** (string)
- **$endcursor** (string) - *Optional*. Bit of data from the JSON to get next batch of photos. Default value is `null`.


**EXAMPLE JSON**

```php
(Instagram\Hydrator\Component\Feed Object)

[id] => 787132
[userName => 'natgeo'
[fullName] => 'National Geographic'
[biography] => 'Experience the world through the eyes of National Geographic photographers.'
[followers] => 98709694
[following] => 135
[profilePicture] => 'https://instagram.fcgk18-1.fna.fbcdn.net/vp/09853aaf5eae10b4f986cf3ea4ba4135/5D00426C/t51.2885-19/s320x320/13597791_261499887553333_1855531912_a.jpg?_nc_ht=instagram.fcgk18-1.fna.fbcdn.net&_nc_cat=1'
[externalUrl] => 'http://natgeo.com/'
[mediaCount] => 19341

[endCursor] => 'QVFBNnZSS01kRVFPMVBYQjFUUzRtU29YRnZsRGQ0T0NZMHJLa0V5c1V3ZzZzaXlmV0Z4cXFGRndtQ2N3QnhPa3JKTTdDODRFTFY0aFY1cmdEUEpDSk15UA=='

[medias] => Array
  [0] => (Instagram\Hydrator\Component\Media)
    [id] => 1967339913658289842
    [typeName] => 'GraphImage'
    [height] => 864
    [width] => 1080
    [thumbnailSrc] => 'https://instagram.fcgk18-1.fna.fbcdn.net/vp/2d36d9922cd0240b12986954144de03d/5CFD29FE/t51.2885-15/e15/c108.0.864.864a/s640x640/49831361_242286123327859_5316757156600178542_n.jpg?_nc_ht=instagram.fcgk18-1.fna.fbcdn.net&_nc_cat=1'
    [link] => 'https://www.instagram.com/p/BtNZTpiDM6y/'
    [date] => (DateTime)
      [date] => '2019-01-29 07:00:15.000000'
      [timezone_type] => 3
      [timezone] => 'UTC'

    [displaySrc] => 'https://instagram.fcgk18-1.fna.fbcdn.net/vp/857455540c1941185a696a06e39d2079/5CF7B4AC/t51.2885-15/fr/e15/s1080x1080/49831361_242286123327859_5316757156600178542_n.jpg?_nc_ht=instagram.fcgk18-1.fna.fbcdn.net&_nc_cat=1'
    [caption] => 'Photo by @simonnorfolkstudio | The Basilica of St Simeon ...'
    [comments] => 260
    [likes] => 86513

    [thumbnails] => Array
      [0] => (stdClass)
        [src] => 'https://instagram.fcgk18-1.fna.fbcdn.net/vp/1bd5ba4d9826f0390c52e8b5916cbfca/5CF8B461/t51.2885-15/e15/c108.0.864.864a/s150x150/49831361_242286123327859_5316757156600178542_n.jpg?_nc_ht=instagram.fcgk18-1.fna.fbcdn.net&_nc_cat=1',
        [config_width] => 150,
        [config_height] => 150

      [1] => (Same param but size 240 x 240)
      [2] => (Size 320 x 320)
      [3] => (Size 480 x 480)
      [4] => (Size 640 x 640)
  
```

Notable parameters:

- **endCursor** - As mentioned above, use this value to get next batch of photos.
- **medias => thumbnailSrc** - 640x640 size, if you need lower resolution, get it from `thumbnails` array.
- **medias => displaySrc** - Original size.