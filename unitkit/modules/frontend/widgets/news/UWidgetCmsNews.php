<?php
/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UWidgetCmsNews extends CWidget
{
    /**
     * ID of newsgroup
     *
     * @var int
     */
    public $id;

    /**
     * Number of results
     *
     * @var int
     */
    public $size;

    protected $_models;

    public function init()
    {
        $this->_models = UCmsNews::model()
            ->with('uCmsNewsI18n')
            ->findAllByAttributes(array(
                    'u_cms_news_group_id' => $this->id,
                    'activated' => 1
                ),
                array(
                    'order' => 'published_at DESC',
                    'limit' => $this->size
                )
            );
    }

    public function run()
    {
    	$i = 0;
    	$count = count($this->_models);
        $countPrev = $count - 1;

    	$html = '<section>';
        foreach($this->_models as $news) {
            $html .= '
                 <div class="row">
                    <div class="box">
                        <div class="col-lg-12 text-center">
                            <h2>
                                '.$news->uCmsNewsI18n->title.'
                                -
                                <small>'.date("F j, Y", strtotime($news->created_at )).'</small>
                            </h2>
                            '.$news->uCmsNewsI18n->content.'
                        </div>
                    </div>
                </div>';
        }
        $html .= '
                 </section>';

        echo $html;
    }
}