<?php

class DashComponentController extends Controller
{
    protected $subMenu = [];
    protected $subTitle = 'Components';

    public function __construct()
    {
        $this->subMenu = [
            'components' => [
                'title'  => 'Components',
                'url'    => URL::route('dashboard.components'),
                'icon'   => 'ion-ios-keypad',
                'active' => false,
            ],
            'groups' => [
                'title'  => 'Component Groups',
                'url'    => URL::route('dashboard.components.groups'),
                'icon'   => 'ion-folder',
                'active' => false,
            ],
        ];

        View::share('subTitle', $this->subTitle);
        View::share('subMenu', $this->subMenu);
    }

    /**
     * Shows the components view.
     *
     * @return \Illuminate\View\View
     */
    public function showComponents()
    {
        $components = Component::orderBy('order')->orderBy('created_at')->get();

        $this->subMenu['components']['active'] = true;

        return View::make('dashboard.components.index')->with([
            'pageTitle'  => 'Components - Dashboard',
            'components' => $components,
            'subMenu'    => $this->subMenu,
        ]);
    }

    /**
     * Shows the component groups view.
     *
     * @return \Illuminate\View\View
     */
    public function showComponentGroups()
    {
        $this->subMenu['groups']['active'] = true;

        return View::make('dashboard.groups')->with([
            'pageTitle' => 'Component Groups - Dashboard',
            'groups'    => Group::all(),
            'subMenu'   => $this->subMenu,
        ]);
    }

    /**
     * Shows the edit component view.
     *
     * @param \Component $component
     *
     * @return \Illuminate\View\View
     */
    public function showEditComponent(Component $component)
    {
        return View::make('dashboard.components.edit')->with([
            'pageTitle' => 'Editing "'.$component->name.'" Component - Dashboard',
            'component' => $component,
        ]);
    }

    /**
     * Updates a component.
     *
     * @param \Component $component
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateComponentAction(Component $component)
    {
        $_component = Input::get('component');
        $component->update($_component);

        return Redirect::back()->with('savedComponent', $component);
    }

    /**
     * Shows the add component view.
     *
     * @return \Illuminate\View\View
     */
    public function showAddComponent()
    {
        return View::make('dashboard.components.add')->with([
            'pageTitle' => 'Add Component - Dashboard',
        ]);
    }

    /**
     * Creates a new component.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createComponentAction()
    {
        $_component = Input::get('component');
        $component = Component::create($_component);

        return Redirect::back()->with('component', $component);
    }

    /**
     * Deletes a given component.
     *
     * @param \Component $component
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteComponentAction(Component $component)
    {
        $component->delete();

        return Redirect::back();
    }

    /**
     * Shows the add component group view.
     *
     * @return \Illuminate\View\View
     */
    public function showAddComponentGroup()
    {
        return View::make('dashboard.components.add-group')->with([
            'pageTitle' => 'Create Component Group',
        ]);
    }
}
