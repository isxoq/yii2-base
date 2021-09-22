<?php


namespace soft\widget;


use yii\base\Widget;
use frontend\assets\VideoJsAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 *
 * @property string|mixed $playerName player name
 */
class VideojsWidget extends Widget
{

    /**
     * @var string Player name
     */
    private $_playerName;

    public $src;

    /**
     * @var int|null the amount of seconds of video
     */
    public $duration;

    /**
     * @var int Starter point of the video
     */
    public $currentTime = 0;

    /**
     * @var array Html options for video tag
     */
    public $options = [];

    public $playerOptions = [];

    /**
     * @var bool
     */
    public $registerEvents = false;


    /**
     * @return mixed
     */
    public function getPlayerName()
    {
        return $this->_playerName;
    }

    /**
     * @param mixed $playerName
     */
    public function setPlayerName($playerName): void
    {
        $this->_playerName = $playerName;
    }

    public function run()
    {

        $this->options = ArrayHelper::merge($this->defaultOptions(), $this->options);
        Html::addCssClass($this->options, 'video-js');

        $id = $this->options['id'];
        $this->playerName = 'player_'.$id;

        $this->playerOptions = ArrayHelper::merge($this->defaultPlayerOptions(), $this->playerOptions);
        $this->registerAssets();
        $vjsNoJs = '  <p class="vjs-no-js">
            To view this video please enable JavaScript, and consider upgrading to a web browser that
            <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
        </p>';
        echo Html::tag('video', $vjsNoJs, $this->options);

    }

    public function defaultOptions()
    {
        return [
            'id' => $this->getId(),
            'controls' => true,
            'preload' => "auto",
            'width' => "100%",
            'height' => "auto",

        ];
    }

    public function defaultPlayerOptions()
    {
        return [
            'src' => $this->src,
            'type' => 'application/x-mpegURL',
            'withCredentials' => true,
        ];
    }

    public function registerAssets()
    {
        VideoJsAsset::register($this->view);
        $this->initPlayer();
        $this->setPlayerDuration();
        $this->setPlayerDuration();
        $this->setPlayerCurrentTime();

    }

    public function initPlayer()
    {

        $id = $this->options['id'];
        $playerOptions = Json::encode($this->playerOptions);
        $js = new JsExpression("
                var {$this->playerName} = videojs('{$id}');
                {$this->playerName}.src({$playerOptions});
            ");
        $this->view->registerJs($js);
    }

    public function setPlayerDuration()
    {
        $duration = intval($this->duration);
        if ( $duration > 0 ){
            $js = new JsExpression("
             {$this->playerName}.duration = function() {
                  return {$duration}; 
                }
            ");

            $this->view->registerJs($js);
        }
    }

    public function setPlayerCurrentTime()
    {
        $duration = intval($this->duration);
        $currentTime = intval($this->currentTime);
        if ($currentTime > 0 ){
            if ($duration > 0){
                if ($currentTime <= $duration){
                    $js = new JsExpression("
                        {$this->playerName}.currentTime({$currentTime}) 
                    ");
                    $this->view->registerJs($js);
                }
            }
            else{
                $js = new JsExpression("
                        {$this->playerName}.currentTime({$currentTime}) 
                    ");
                $this->view->registerJs($js);
            }

        }
    }


}