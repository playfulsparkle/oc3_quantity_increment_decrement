<?php
class ControllerExtensionModulePsQuantityIncrementDecrement extends Controller
{
    /**
     * @var string The support email address.
     */
    const EXTENSION_EMAIL = 'support@playfulsparkle.com';

    /**
     * @var string The URL to the support website.
     */
    const SUPPORT_URL = 'https://support.playfulsparkle.com';

    /**
     * @var string The GitHub repository URL of the extension.
     */
    const GITHUB_REPO_URL = 'https://github.com/playfulsparkle/oc3_quantity_increment_decrement';

    private $error = array();

    public function index()
    {
        $this->load->language('extension/module/ps_quantity_increment_decrement');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('module_ps_quantity_increment_decrement', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/ps_quantity_increment_decrement', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link('extension/module/ps_quantity_increment_decrement', 'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        if (isset($this->request->post['module_ps_quantity_increment_decrement_status'])) {
            $data['module_ps_quantity_increment_decrement_status'] = (bool) $this->request->post['module_ps_quantity_increment_decrement_status'];
        } else {
            $data['module_ps_quantity_increment_decrement_status'] = (bool) $this->config->get('module_ps_quantity_increment_decrement_status');
        }


        if (isset($this->request->post['module_ps_quantity_increment_decrement_base_theme'])) {
            $data['module_ps_quantity_increment_decrement_base_theme'] = $this->request->post['module_ps_quantity_increment_decrement_base_theme'];
        } else {
            $data['module_ps_quantity_increment_decrement_base_theme'] = $this->config->get('module_ps_quantity_increment_decrement_base_theme');
        }

        if (isset($this->request->post['module_ps_quantity_increment_decrement_override_base_theme'])) {
            $data['module_ps_quantity_increment_decrement_override_base_theme'] = (bool) $this->request->post['module_ps_quantity_increment_decrement_override_base_theme'];
        } else {
            $data['module_ps_quantity_increment_decrement_override_base_theme'] = (bool) $this->config->get('module_ps_quantity_increment_decrement_override_base_theme');
        }

        if (isset($this->request->post['module_ps_quantity_increment_decrement_text_align'])) {
            $data['module_ps_quantity_increment_decrement_text_align'] = $this->request->post['module_ps_quantity_increment_decrement_text_align'];
        } else {
            $data['module_ps_quantity_increment_decrement_text_align'] = $this->config->get('module_ps_quantity_increment_decrement_text_align');
        }

        if (isset($this->request->post['module_ps_quantity_increment_decrement_btn_icon'])) {
            $data['module_ps_quantity_increment_decrement_btn_icon'] = $this->request->post['module_ps_quantity_increment_decrement_btn_icon'];
        } else {
            $data['module_ps_quantity_increment_decrement_btn_icon'] = $this->config->get('module_ps_quantity_increment_decrement_btn_icon');
        }

        if (isset($this->request->post['module_ps_quantity_increment_decrement_show_on_page'])) {
            $data['module_ps_quantity_increment_decrement_show_on_page'] = (array) $this->request->post['module_ps_quantity_increment_decrement_show_on_page'];
        } else {
            $data['module_ps_quantity_increment_decrement_show_on_page'] = (array) $this->config->get('module_ps_quantity_increment_decrement_show_on_page');
        }


        if (isset($this->request->post['module_ps_quantity_increment_decrement_btn_color'])) {
            $data['module_ps_quantity_increment_decrement_btn_color'] = $this->request->post['module_ps_quantity_increment_decrement_btn_color'];
        } else {
            $data['module_ps_quantity_increment_decrement_btn_color'] = $this->config->get('module_ps_quantity_increment_decrement_btn_color');
        }

        if (isset($this->request->post['module_ps_quantity_increment_decrement_btn_bg_start'])) {
            $data['module_ps_quantity_increment_decrement_btn_bg_start'] = $this->request->post['module_ps_quantity_increment_decrement_btn_bg_start'];
        } else {
            $data['module_ps_quantity_increment_decrement_btn_bg_start'] = $this->config->get('module_ps_quantity_increment_decrement_btn_bg_start');
        }

        if (isset($this->request->post['module_ps_quantity_increment_decrement_btn_bg_end'])) {
            $data['module_ps_quantity_increment_decrement_btn_bg_end'] = $this->request->post['module_ps_quantity_increment_decrement_btn_bg_end'];
        } else {
            $data['module_ps_quantity_increment_decrement_btn_bg_end'] = $this->config->get('module_ps_quantity_increment_decrement_btn_bg_end');
        }

        if (isset($this->request->post['module_ps_quantity_increment_decrement_btn_border_color_all'])) {
            $data['module_ps_quantity_increment_decrement_btn_border_color_all'] = $this->request->post['module_ps_quantity_increment_decrement_btn_border_color_all'];
        } else {
            $data['module_ps_quantity_increment_decrement_btn_border_color_all'] = $this->config->get('module_ps_quantity_increment_decrement_btn_border_color_all');
        }

        if (isset($this->request->post['module_ps_quantity_increment_decrement_btn_border_color_bottom'])) {
            $data['module_ps_quantity_increment_decrement_btn_border_color_bottom'] = $this->request->post['module_ps_quantity_increment_decrement_btn_border_color_bottom'];
        } else {
            $data['module_ps_quantity_increment_decrement_btn_border_color_bottom'] = $this->config->get('module_ps_quantity_increment_decrement_btn_border_color_bottom');
        }

        if (isset($this->request->post['module_ps_quantity_increment_decrement_btn_hover_bg'])) {
            $data['module_ps_quantity_increment_decrement_btn_hover_bg'] = $this->request->post['module_ps_quantity_increment_decrement_btn_hover_bg'];
        } else {
            $data['module_ps_quantity_increment_decrement_btn_hover_bg'] = $this->config->get('module_ps_quantity_increment_decrement_btn_hover_bg');
        }

        if (isset($this->request->post['module_ps_quantity_increment_decrement_btn_active_bg'])) {
            $data['module_ps_quantity_increment_decrement_btn_active_bg'] = $this->request->post['module_ps_quantity_increment_decrement_btn_active_bg'];
        } else {
            $data['module_ps_quantity_increment_decrement_btn_active_bg'] = $this->config->get('module_ps_quantity_increment_decrement_btn_active_bg');
        }

        if (isset($this->request->post['module_ps_quantity_increment_decrement_btn_disabled_bg'])) {
            $data['module_ps_quantity_increment_decrement_btn_disabled_bg'] = $this->request->post['module_ps_quantity_increment_decrement_btn_disabled_bg'];
        } else {
            $data['module_ps_quantity_increment_decrement_btn_disabled_bg'] = $this->config->get('module_ps_quantity_increment_decrement_btn_disabled_bg');
        }


        $data['text_contact'] = sprintf($this->language->get('text_contact'), self::SUPPORT_URL, self::GITHUB_REPO_URL, self::EXTENSION_EMAIL);

        $data['btn_classnames'] = array(
            'btn-primary' => $this->language->get('text_btn_primary'),
            'btn-default' => $this->language->get('text_btn_default'),
            'btn-success' => $this->language->get('text_btn_success'),
            'btn-info' => $this->language->get('text_btn_info'),
            'btn-warning' => $this->language->get('text_btn_warning'),
            'btn-danger' => $this->language->get('text_btn_danger'),
        );

        $data['btn_icons'] = array(
            'plus-minus' => $this->language->get('text_icon_plus_minus'),
            'chevron-left-right' => $this->language->get('text_icon_chevron_left_right'),
            'arrow-up-down' => $this->language->get('text_icon_arrow_up_down'),
        );

        $data['show_on_pages'] = array(
            'category_page' => $this->language->get('text_category_page'),
            'detail_page' => $this->language->get('text_detail_page'),
            'compare_page' => $this->language->get('text_compare_page'),
            'cart_page' => $this->language->get('text_cart_page'),
            'wishlist_page' => $this->language->get('text_wishlist_page'),
            'manufacturer_page' => $this->language->get('text_manufacturer_page'),
            'search_page' => $this->language->get('text_search_page'),
            'special_page' => $this->language->get('text_special_page'),
            'special_module' => $this->language->get('text_special_module'),
            'latest_module' => $this->language->get('text_latest_module'),
            'bestseller_module' => $this->language->get('text_bestseller_module'),
            'featured_module' => $this->language->get('text_featured_module'),
        );

        $data['text_aligns'] = array(
            'end' => $this->language->get('text_align_natural'),
            'center' => $this->language->get('text_align_center'),
        );

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/ps_quantity_increment_decrement', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/ps_quantity_increment_decrement')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {

        }

        return !$this->error;
    }

    public function install()
    {
        $this->load->model('setting/setting');

        $data = array(
            'module_ps_quantity_increment_decrement_status' => 0,
            'module_ps_quantity_increment_decrement_base_theme' => 'btn-secondary',
            'module_ps_quantity_increment_decrement_override_base_theme' => 0,
            'module_ps_quantity_increment_decrement_text_align' => 'end',
            'module_ps_quantity_increment_decrement_btn_icon' => 'plus-minus',
            'module_ps_quantity_increment_decrement_show_on_page' => array('detail_page', 'cart_page'),
            'module_ps_quantity_increment_decrement_btn_color' => '#777',
            'module_ps_quantity_increment_decrement_btn_bg_start' => '#eeeeee',
            'module_ps_quantity_increment_decrement_btn_bg_end' => '#dddddd',
            'module_ps_quantity_increment_decrement_btn_border_color_all' => '#bbbbbb',
            'module_ps_quantity_increment_decrement_btn_border_color_bottom' => '#7a7a7a',
            'module_ps_quantity_increment_decrement_btn_hover_bg' => '#bbbbbb',
            'module_ps_quantity_increment_decrement_btn_active_bg' => '#bbbbbb',
            'module_ps_quantity_increment_decrement_btn_disabled_bg' => '#bbbbbb',
        );

        $this->model_setting_setting->editSetting('module_ps_quantity_increment_decrement', $data);
    }

    public function uninstall()
    {

    }
}
