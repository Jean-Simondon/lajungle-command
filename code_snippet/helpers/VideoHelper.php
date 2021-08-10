<?php
namespace YOUR_THEME_NAME\Helpers;

class VideoHelper
{
    public static function getVideoId($typeVideo, $VideoUrl)
    {
        $idVideo = '';

        if ('youtube' === $typeVideo) {
            $idVideo = VideoHelper::getYoutubeId($VideoUrl);
        } elseif ('vimeo' === $typeVideo) {
            $idVideo = VideoHelper::getVimeoId($VideoUrl);
        } elseif ('stream' === $typeVideo) {
            $idVideo = str_replace('https://web.microsoftstream.com/embed/video/', '', $VideoUrl);
        }

        return $idVideo;
    }

    /**
     * Recupere l'id d'un video youtube depuis son url
     * @param string $sVideoUrl url de la video youtube
     * @return string l'id de la video youtube
     */
    public static function getYoutubeId($sVideoUrl)
    {
        $eReg = "/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/";
        preg_match($eReg, $sVideoUrl, $matches);
        $sId = $matches[ count($matches) - 1 ];

        return $sId;
    }

    /**
     * Recupere l'id d'un video Vimeo depuis son url
     * @param string $sVideoUrl url de la video youtube
     * @return string l'id de la video youtube
     */
    public static function getVimeoId($sVideoUrl)
    {
        $eReg = "/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/";
        preg_match($eReg, $sVideoUrl, $matches);
        $sId = $matches[ 5 ];

        return $sId;
    }

    /**
     * Récupère l'url du thumbnail de la vidéo
     * @param $typeVideo
     * @param $VideoUrl
     * @return null | string
     */
    public static function getThumbnail($typeVideo, $VideoUrl)
    {
        if ($typeVideo === 'youtube') {
            $idVideo = VideoHelper::getYoutubeId($VideoUrl);
            return "https://img.youtube.com/vi/$idVideo/hqdefault.jpg";

        }elseif ($typeVideo === 'vimeo') {
            // https://developer.vimeo.com/api/oembed/videos
            $url = "https://vimeo.com/api/oembed.json?url=$VideoUrlx%x%width=1280&height=720";
            $json = json_decode(file_get_contents($url));

            return isset($json->thumbnail_url) ? $json->thumbnail_url : null;

        } elseif ($typeVideo === 'stream') {
            // https://docs.microsoft.com/fr-fr/stream/embed-video-oembed
            $url = "https://web.microsoftstream.com/oembed?url=$VideoUrlx%x%preload=true&autoplay=true&width=1280&height=720";
            $json = json_decode(file_get_contents($url));

            return isset($json->thumbnail_url) ? $json->thumbnail_url : null;
        }

    }
}

// JAVASCRIPT :

// $('body').on('click', '.js-reveal-video', revealVideo);

//     function revealVideo(e) {
//         e.preventDefault();
//         var $this = $(this);
//         var iframe = $(this).next();
//         var iframedId = $(this).attr('data-iframe-src');
//         var typeVideo = $(this).attr('data-video-type');
//         var uniqueID = $(this).attr('data-unique-id');
//         if (typeVideo === 'youtube') {
//             var iframeSettings = '?rel=0&showinfo=0&autoplay=1';
//             var url = 'https://www.youtube-nocookie.com/embed/' + iframedId + iframeSettings;
//         }

//         if ( typeVideo === "stream") {
//             var url = "https://web.microsoftstream.com/embed/video/"+iframedId+"?autoplay=true&showinfo=false&uniqid="+uniqueID;
//         }

//         if (typeVideo === 'vimeo') {
//             var url = "https://player.vimeo.com/video/"+iframedId+"?autoplay=1";
//         }

//         iframe.attr("src", url);

//         setTimeout(function() {
//             $this.fadeOut();
//         }, 1000);
//     }

// TEMPLATE :

// @php
//     use Semsamar\Helpers\VideoHelper;
//     $idVideo = VideoHelper::getVideoId( $video['type_de_video'], $video['url_de_la_video']);
//     $thumbnail = VideoHelper::getThumbnail( $video['type_de_video'], $video['url_de_la_video']);
// @endphp
// <div class="bloc_video">

//     <div class="js-reveal-video" data-unique-id="{{uniqid()}}" data-video-type="{{$video['type_de_video']}}" data-iframe-src="{{$idVideo}}">
//         <span class="icon"></span>
//         <img src="{{$thumbnail}}" alt=""/>
//         @if($bloc['texte'])
//             <p class="excerpt">{!! $bloc['texte'] !!}</p>
//         @endif
//     </div>

//     <iframe class="video-iframe-sidebar" 
//             src="" frameborder="0" 
//             allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"></iframe>
// </div>