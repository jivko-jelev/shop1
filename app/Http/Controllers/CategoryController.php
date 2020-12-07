<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use App\Property;
use App\SubProperty;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::select('categories.*', 'c.title as primary_category_title')
                              ->leftJoin('categories as c', 'categories.parent_id', 'c.id')
                              ->get();

        foreach ($categories as $category) {
            $category->actions = view('admin.categories.partials.actions')->with('category', $category)->render();
        }

        return view('admin.categories.index', [
            'data'  => $categories,
            'title' => 'Категории',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.categories.create', [
            'categories' => Category::all(),
            'route'      => route('categories.store'),
            'method'     => 'post',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryRequest $category)
    {
        DB::transaction(function () use ($category) {
            $cat = Category::create([
                'title'     => $category->title,
                'alias'     => mb_strtolower($category->alias),
                'parent_id' => $category->parent_id,
            ]);

            $this->createProperties($cat->id);
        });

        return response()->json([
            'content' => view('admin.categories.partials.edit-content', [
                    'categories' => Category::all(),
                    'route'      => route('categories.store'),
                ]
            )->render(),
            'message' => 'Категорията беше успешно записана']);
    }


    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * @param Category $category
     * @return array|string
     * @throws Throwable
     */
    public function edit(Category $category)
    {
        $category->load(['properties' => function ($query) {
            $query->with('subProperties')
                  ->withCount('subProperties');
        }]);

        return view('admin.categories.edit', [
            'category' => $category,
            'route'    => route('categories.update', $category),
            'method'   => 'put',
        ])->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Category        $category
     * @param Request         $request
     * @param CategoryRequest $categoryRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws Throwable
     */
    public function update(Category $category, CategoryRequest $categoryRequest)
    {
        $category->title     = $categoryRequest->title;
        $category->alias     = $categoryRequest->alias;
        $category->parent_id = $categoryRequest->parent_id;
        $category->save();

        if ($categoryRequest->property) {
            $data = [];
            // Обновяване на данните за атрибутите на категорията
            foreach ($categoryRequest->property as $key => $property) {
                Property::where('id', $key)
                        ->update([
                            'name'                       => $property,
                            'multiple_selection_allowed' => $categoryRequest->multi[$key] ?? false,
                        ]);

                if (isset($categoryRequest->new_subproperty[$key])) {
                    // Добавяне на нови податрибути към този атрибут
                    foreach ($categoryRequest->new_subproperty[$key] as $key1 => $subproperty) {
                        $data[] = [
                            'name'        => $subproperty,
                            'property_id' => $key,
                        ];
                    }
                }
            }
            SubProperty::insert($data);
        }

        if ($categoryRequest->subproperty) {
            foreach ($categoryRequest->subproperty as $key => $property) {
                foreach ($property as $key1 => $subProperty) {
                    SubProperty::where('id', $key1)
                               ->update(['name' => $subProperty]);
                }
            }
        }

        $this->createProperties($category->id);

        return response()->json([
            'message' => 'Категорията беше успешно редактирана.',
            'content' => view('admin.categories.partials.edit-content', [
                'categories' => Category::all(),
                'category'   => $category,
                'route'      => route('categories.update', $category),
            ])->render(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return void
     * @throws Exception
     */
    public function destroy(Category $category)
    {
        $category->delete();
    }

    public function addProperty()
    {
        return view('admin.categories.partials.add-property');
    }

    public function addSubProperty()
    {
        return view('admin.categories.partials.add-subproperty');
    }

    public function createProperties($category_id)
    {
        if (request()->get('new_property')) {
            $data = [];
            foreach (request()->get('new_property') as $key => $property) {
                $property = Property::create([
                    'name'                       => $property,
                    'category_id'                => $category_id,
                    'multiple_selection_allowed' => isset(request()->get('multiple')[$key]),
                ]);

                foreach (request()->get('new_subproperty')[$key] as $subProperty) {
                    $data[] = [
                        'name'        => $subProperty,
                        'property_id' => $property->id,
                    ];
                }
            }
            SubProperty::insert($data);
        }
    }

    public function ajax(Request $request)
    {
        $categories = Category::select('id', 'title', 'parent_id', 'alias');

        $ajaxGridColumnNames = [
            0 => 'title',
            1 => 'alias',
            2 => 'parent_id',
        ];

        $categories->whereLikeIf('title', $request->get('title'))
                   ->whereLikeIf('alias', $request->get('alias'))
                   ->when($request->get('parent'), function ($query) use ($request) {
                       $parentCategories = Category::where('title', 'like', "%{$request->get('parent')}%")->pluck('id');
                       $query->whereIn('parent_id', $parentCategories);
                   });

        $orderState = $request->get('order');
        foreach ($orderState as $singleOrderState) {
            $categories->orderBy($ajaxGridColumnNames[$singleOrderState['column']], $singleOrderState['dir']);
        }

        $categories   = $categories->get();
        $recordsTotal = $recordsFiltered = $categories->count();

        $c = Category::all()->pluck('title', 'id')->toArray();
        foreach ($categories as $category) {
            $category->actions = view('admin.categories.partials.actions')->with('category', $category)->render();
            if ($category->parent_id) {
                $category->parent_id = $c[$category->parent_id];
            }
        }

        return response()->json([
            'data'            => $categories,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
        ]);
    }

    /**
     * @param Category $category
     * @return array|string
     * @throws Throwable
     */
    public function getProperties(Category $category)
    {
        $properties = Property::with('subProperties')
                              ->where('category_id', $category->id)
                              ->get();

        return view('admin.products.layouts.properties', compact('properties'))->render();
    }
}
