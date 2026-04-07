<?php
class ControllerExtensionModulePsQuantityIncrementDecrement extends Controller
{
    public function autocomplete()
    {
        if (isset($this->request->get['search'])) {
            $search = $this->request->get['search'];
        } else {
            $search = '';
        }

        $json = array(
            'products' => array(
                'status' => (bool) $this->config->get('module_ps_quantity_increment_decrement_product_status'),
                'show_price' => (bool) $this->config->get('module_ps_quantity_increment_decrement_product_price'),
                'data' => array()
            ),
            'categories' => array(
                'status' => (bool) $this->config->get('module_ps_quantity_increment_decrement_category_status'),
                'data' => array()
            ),
            'manufacturers' => array(
                'status' => (bool) $this->config->get('module_ps_quantity_increment_decrement_manufacturer_status'),
                'data' => array()
            ),
            'informations' => array(
                'status' => (bool) $this->config->get('module_ps_quantity_increment_decrement_information_status'),
                'data' => array()
            ),
        );

        $this->load->model('extension/module/ps_quantity_increment_decrement');
        $this->load->model('tool/image');

        if ($this->config->get('module_ps_quantity_increment_decrement_product_status')) {
            $productResults = $this->model_extension_module_ps_quantity_increment_decrement->getProducts($search);

            foreach ($productResults as $productResult) {
                if ($this->config->get('module_ps_quantity_increment_decrement_product_price')) {
                    if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                        $price = $this->currency->format($this->tax->calculate($productResult['price'], $productResult['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                    } else {
                        $price = false;
                    }

                    if ((float) $productResult['special']) {
                        $special = $this->currency->format($this->tax->calculate($productResult['special'], $productResult['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                    } else {
                        $special = false;
                    }

                    if ($this->config->get('config_tax')) {
                        $tax = $this->currency->format((float) $productResult['special'] ? $productResult['special'] : $productResult['price'], $this->session->data['currency']);
                    } else {
                        $tax = false;
                    }
                } else {
                    $price = false;
                    $special = false;
                    $tax = false;
                }

                if ($this->config->get('module_ps_quantity_increment_decrement_product_image') && !empty($productResult['image'])) {
                    $thumb = $this->model_tool_image->resize($productResult['image'], $this->config->get('module_ps_quantity_increment_decrement_product_image_width'), $this->config->get('module_ps_quantity_increment_decrement_product_image_height'));
                } else {
                    $thumb = '';
                }

                if ($this->config->get('module_ps_quantity_increment_decrement_product_description') && $this->config->get('module_ps_quantity_increment_decrement_product_description_length') > 0) {
                    $description = utf8_substr(trim(strip_tags(html_entity_decode($productResult['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('module_ps_quantity_increment_decrement_product_description_length')) . '..';
                } else {
                    $description = '';
                }

                $json['products']['data'][] = array(
                    'href' => str_replace('&amp;', '&', $this->url->link('product/product', 'product_id=' . $productResult['product_id'])),
                    'name' => strip_tags($productResult['name']),
                    'description' => $description,
                    'price' => $price,
                    'special' => $special,
                    'tax' => $tax,
                    'thumb' => $thumb,
                    'thumb_width' => $this->config->get('module_ps_quantity_increment_decrement_product_image_width'),
                    'thumb_height' => $this->config->get('module_ps_quantity_increment_decrement_product_image_height'),
                );
            }
        }

        if ($this->config->get('module_ps_quantity_increment_decrement_category_status')) {
            $categoryResults = $this->model_extension_module_ps_quantity_increment_decrement->getCategories($search);

            foreach ($categoryResults as $categoryResult) {
                if ($this->config->get('module_ps_quantity_increment_decrement_category_image') && !empty($categoryResult['image'])) {
                    $thumb = $this->model_tool_image->resize($categoryResult['image'], $this->config->get('module_ps_quantity_increment_decrement_category_image_width'), $this->config->get('module_ps_quantity_increment_decrement_category_image_height'));
                } else {
                    $thumb = '';
                }

                $name = array($categoryResult['names']);

                if ($categoryResult['name']) {
                    $name[] = $categoryResult['name'];
                }

                $paths = array_filter([$categoryResult['paths'], $categoryResult['category_id']]);

                $json['categories']['data'][] = array(
                    'href' => str_replace('&amp;', '&', $this->url->link('product/category', 'path=' . implode('_', $paths))),
                    'name' => implode(' > ', array_filter($name)),
                    'thumb' => $thumb,
                    'thumb_width' => $this->config->get('module_ps_quantity_increment_decrement_category_image_width'),
                    'thumb_height' => $this->config->get('module_ps_quantity_increment_decrement_category_image_height'),
                );
            }
        }

        if ($this->config->get('module_ps_quantity_increment_decrement_manufacturer_status')) {
            $manufacturerResults = $this->model_extension_module_ps_quantity_increment_decrement->getManufacturers($search);

            foreach ($manufacturerResults as $manufacturerResult) {

                if ($this->config->get('module_ps_quantity_increment_decrement_manufacturer_image') && !empty($manufacturerResult['image'])) {
                    $thumb = $this->model_tool_image->resize($manufacturerResult['image'], $this->config->get('module_ps_quantity_increment_decrement_manufacturer_image_width'), $this->config->get('module_ps_quantity_increment_decrement_manufacturer_image_height'));
                } else {
                    $thumb = '';
                }

                $json['manufacturers']['data'][] = array(
                    'href' => str_replace('&amp;', '&', $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $manufacturerResult['manufacturer_id'])),
                    'name' => $manufacturerResult['name'],
                    'thumb' => $thumb,
                    'thumb_width' => $this->config->get('module_ps_quantity_increment_decrement_manufacturer_image_width'),
                    'thumb_height' => $this->config->get('module_ps_quantity_increment_decrement_manufacturer_image_height'),
                );
            }
        }

        if ($this->config->get('module_ps_quantity_increment_decrement_information_status')) {
            $informationResults = $this->model_extension_module_ps_quantity_increment_decrement->getInformations($search);

            foreach ($informationResults as $informationResult) {
                $json['informations']['data'][] = array(
                    'href' => str_replace('&amp;', '&', $this->url->link('information/information', 'information_id=' . $informationResult['information_id'])),
                    'name' => $informationResult['title']
                );
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json, JSON_UNESCAPED_SLASHES));
    }
}
