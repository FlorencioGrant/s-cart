<?php
#App\Plugins\Modules\Cms\Content\Controllers\ContentController.php
namespace App\Plugins\Modules\Cms\Content\Controllers;

use App\Plugins\Modules\Cms\Content\Models\CmsCategory;
use App\Plugins\Modules\Cms\Content\Models\CmsContent;
use App\Http\Controllers\GeneralController;
class ContentController extends GeneralController
{
/**
 * [news description]
 * @return [type] [description]
 */
public function category($name, $id)
{
    $category_currently = CmsCategory::find($id);
    $entries = (new CmsCategory)
        ->getContentsToCategory($id, $limit = sc_config('product_new'), $opt = 'paginate');
    return view(
        'Modules/Cms/Content::cms_category',
        array(
            'title' => $category_currently['title'],
            'description' => $category_currently['description'],
            'keyword' => $category_currently['keyword'],
            'entries' => $entries,
        )
    );
}

public function content($name, $id)
{
    $entry_currently = CmsContent::find($id);
    if ($entry_currently) {
        $title = ($entry_currently) ? $entry_currently->title : trans('front.not_found');
        return view('Modules/Cms/Content::cms_entry_detail',
            array(
                'title' => $title,
                'entry_currently' => $entry_currently,
                'description' => $entry_currently['description'],
                'keyword' => $entry_currently['keyword'],
                'og_image' => $entry_currently->getImage(),
            )
        );
    } else {
        return view('templates.' . sc_store('template') . '.notfound',
            array(
                'title' => trans('front.not_found'),
                'description' => '',
                'keyword' => sc_store('keyword'),
                'msg' => trans('front.item_not_found'),
            )
        );
    }

}
}
