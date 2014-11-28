<?php
/*
*   Members page. Used to renew subscription.
*
*
*     Author: Alex Scott
*      Email: alex@cgi-central.net
*        Web: http://www.cgi-central.net
*    Details: Member display page
*    FileName $RCSfile$
*    Release: 4.4.2 ($Revision: 5371 $)
*
* Please direct bug reports,suggestions or feedback to the cgi-central forums.
* http://www.cgi-central.net/forum/
*
* aMember PRO is a commercial software. Any distribution is strictly prohibited.
*
*/

include_once 'MediaController.php';

class VideoController extends MediaController
{
    protected $type = 'video';
    function getFlowplayerParams(ResourceAbstractFile $media)
    {
        $config = $this->getPlayerConfig($media);
        
        if ($media->poster_id)
            $config['autoPlay'] = true;

        $params = array (
            'key' => $this->getDi()->config->get('flowplayer_license'),
            'height' => @$config['height'],
            'width' => @$config['width'],
            'clip' => array(
                    'autoPlay' => (isset($config['autoPlay']) && $config['autoPlay']) ? true : false,
                    'autoBuffering' => (isset($config['autoBuffering']) && $config['autoBuffering']) ? true : false,
                    'bufferLength' => isset($config['bufferLength']) ? $config['bufferLength'] : 3,
                    'scaling' => isset($config['scaling']) ? $config['scaling'] : 'scale'
                ),
        );

        return $params;
    }

    public
        function getJWPlayerParams(\ResourceAbstractFile $media)
    {
        $config = $this->getPlayerConfig($media);
        if ($media->poster_id)
            $config['autoPlay'] = true;
        
        switch(@$config['scaling']){
            case 'orig' :   $stretching = 'none'; break;
            case 'fit'  :   $stretching = 'uniform'; break;
            case 'scale' : $stretching = 'exactfit'; break;
            default: $stretching = 'uniform';
                
        }
        
        return array(
            'key' => $this->getDi()->config->get('jwplayer_license'),
            'height' => @$config['height'],
            'width' => @$config['width'],
            'autostart' => @$config['autoPlay'],
            'stretching' => $stretching
            
        );
    }
}