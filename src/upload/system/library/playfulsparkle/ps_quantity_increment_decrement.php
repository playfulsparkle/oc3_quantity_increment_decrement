<?php
namespace playfulsparkle;

class ps_quantity_increment_decrement
{
    /**
     * Get FontAwesome icon classes for increment/decrement buttons based on selected style.
     *
     * @param string $style The stored style value (e.g., 'plus-minus', 'chevron-left-right', 'arrow-up-down')
     * @return array Associative array with 'increment' and 'decrement' keys containing CSS classes
     */
    public function getButtonIconClasses($style)
    {
        switch ($style) {
            case 'chevron-left-right':
                return array(
                    'increment' => 'fa fa-chevron-right',
                    'decrement' => 'fa fa-chevron-left'
                );
            case 'arrow-up-down':
                return array(
                    'increment' => 'fa fa-arrow-up',
                    'decrement' => 'fa fa-arrow-down'
                );
            case 'plus-minus':
            default:
                return array(
                    'increment' => 'fa fa-plus',
                    'decrement' => 'fa fa-minus'
                );
        }
    }
}
