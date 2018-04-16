<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\UserRepository;
use DataTables;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    private $userRepository;

    protected $user;

    public function __construct(
        CategoryRepository $categoryRepository,
        UserRepository $userRepository
    )
    {
        parent::__construct();

        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;

        view()->share('type', 'category');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->generateParams();
        if ((!$this->user->hasAccess(['products.read'])) && $this->user->orgRole=='staff') {
            return redirect('dashboard');
        }
        $title = trans('category.categories');

        return view('user.category.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->generateParams();
        if ((!$this->user->hasAccess(['products.write'])) && $this->user->orgRole=='staff') {
            return redirect('dashboard');
        }
        $title = trans('category.new');

        return view('user.category.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $this->generateParams();
        if ((!$this->user->hasAccess(['products.write'])) && $this->user->orgRole=='staff') {
            return redirect('dashboard');
        }
        $user = $this->userRepository->getUser();
        $organization = $this->userRepository->getOrganization();
        $request->merge(['user_id'=>$user->id,'organization_id'=>$organization->id]);

        $this->categoryRepository->create($request->all());

        return redirect('category');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($category)
    {
        $this->generateParams();
        if ((!$this->user->hasAccess(['products.read'])) && $this->user->orgRole=='staff') {
            return redirect('dashboard');
        }
        $category = $this->categoryRepository->find($category);
        $title = trans('category.details');
        $action = trans('action.show');

        return view('user.category.show', compact('title', 'category', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($category)
    {
        $this->generateParams();
        if ((!$this->user->hasAccess(['products.write'])) && $this->user->orgRole=='staff') {
            return redirect('dashboard');
        }
        $category = $this->categoryRepository->find($category);
        $title = trans('category.edit');

        return view('user.category.edit', compact('title', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $category)
    {
        $this->generateParams();
        if ((!$this->user->hasAccess(['products.write'])) && $this->user->orgRole=='staff') {
            return redirect('dashboard');
        }
        $category = $this->categoryRepository->find($category);
        $category->update($request->all());

        return redirect('category');
    }

    public function delete($category)
    {
        $this->generateParams();
        if ((!$this->user->hasAccess(['products.delete'])) && $this->user->orgRole=='staff') {
            return redirect('dashboard');
        }
        $category = $this->categoryRepository->find($category);
        $action = '';
        $title = trans('category.delete');

        return view('user.category.delete', compact('title', 'category', 'action'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($category)
    {
        $this->generateParams();
        if ((!$this->user->hasAccess(['products.delete'])) && $this->user->orgRole=='staff') {
            return redirect('dashboard');
        }
        $category = $this->categoryRepository->find($category);
        $category->delete();

        return redirect('category');
    }

    public function data()
    {
        $orgRole = $this->getUser()->orgRole;
        $categories = $this->categoryRepository->getAll()
            ->map(function ($category) use ($orgRole) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'count_uses' => $category->products->count(),
                    'orgRole' => $orgRole,
                ];
            });

        return DataTables::of($categories)
            ->addColumn('actions', '@if(Sentinel::getUser()->hasAccess([\'products.write\']) || $orgRole=="admin")
<a href="{{ url(\'category/\' . $id . \'/edit\' ) }}"  title="{{ trans(\'table.edit\') }}">
                                            <i class="fa fa-fw fa-pencil text-warning"></i> </a>
                                            @endif
                                            @if(Sentinel::getUser()->hasAccess([\'products.delete\']) && $count_uses==0 || $orgRole=="admin" && $count_uses==0)
                                     <a href="{{ url(\'category/\' . $id . \'/delete\' ) }}"  title="{{ trans(\'table.delete\') }}">
                                            <i class="fa fa-fw fa-trash text-danger"></i> </a>
                                     @endif')
            ->removeColumn('id')
            ->removeColumn('count_uses')
            ->rawColumns(['actions'])
            ->make();
    }

    private function generateParams(){
        $this->user = $this->getUser();
    }
}
