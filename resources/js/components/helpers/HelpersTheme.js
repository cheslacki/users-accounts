/**
 * Created by Leonardo Cheslacki on 25/03/2023.
 *
 * INSPINIA - Responsive Admin Theme
 * version 2.9.4
 */
import HelpersController from './HelpersController';

import {HelpersStyle} from './';

/**
 *
 */
class HelpersTheme extends HelpersController {

    /**
     *
     * @param props
     */
    constructor(props) {
        super(props);
        Boolean(props.pace) && this.pace();
        jQuery(document).ready(() => {
            Boolean(props.sideMenu) && this.sideMenu();
            Boolean(props.menuMinimize) && this.menuMinimize();
            Boolean(props.radioAndCheckbox) && this.radioAndCheckbox();
            Boolean(props.checkbox) && this.checkbox();
        });
    };

    pace = () => {
        Pace.start();
    };

    /**
     * Side Menu
     * metisMenu
     */
    sideMenu = () => {
        if (jQuery.isFunction(jQuery.fn.metisMenu)) {
            const $element = jQuery('#side-menu');
            if (!!$element && Boolean($element.length)) {
                $element.metisMenu();
            }
        }
    };

    menuMinimize = () => {
        const elements = jQuery('.navbar-minimalize');

        const execute = (event) => {
            this.stopPropagation(event);
            const
                body = jQuery(event.target).closest('body'),
                menu = body.find('.metismenu');

            if (!!menu && Boolean(menu.length)) {
                body.toggleClass('mini-navbar');
                if (!body.hasClass('mini-navbar') || body.hasClass('body-small')) {
                    menu.hide();
                    this.throttle('helpers-theme-menu-minimize', () => {
                        menu.fadeIn(400);
                    }, 100);
                } else if (body.hasClass('fixed-sidebar')) {
                    menu.hide();
                    this.throttle('helpers-theme-menu-minimize', () => {
                        menu.fadeIn(400);
                    }, 100);
                } else {
                    menu.removeAttr('style');
                }
            }
        };

        if (!!elements && Boolean(elements.length)) {
            elements.off('click.navbar-minimalize');
            elements.on('click.navbar-minimalize', execute);
        }
    };

    /**
     * Radio and Checkbox
     * iCheck
     */
    radioAndCheckbox = () => {
        if (jQuery.isFunction(jQuery.fn.iCheck)) {
            const $elements = jQuery('.radio input[type="radio"], .checkbox input[type=checkbox]');

            if (!!$elements && Boolean($elements.length)) {
                $elements.iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                    increaseArea: '20%'
                });
            }
        }
    };

    /**
     * Checkbox from _id
     * iCheck
     */
    checkbox = () => {
        if (jQuery.isFunction(jQuery.fn.iCheck)) {
            const $elements = jQuery('.sheet-content .list-table');

            const execute = (event) => {
                this.stopPropagation(event);

                const $this = jQuery(event.target);

                if ((/^checkbox_all_/).test($this.attr('id'))) {
                    let $checkboxes = $this.closest('table').find('.checkbox [id^="checkbox_"]').not($this);

                    if (!!$checkboxes && Boolean($checkboxes.length)) {
                        if (event.type === 'ifChecked') {
                            $checkboxes.iCheck('check');
                        } else {
                            $checkboxes.iCheck('uncheck');
                        }
                    }
                }
            };

            if (!!$elements && Boolean($elements.length)) {
                $elements.off('ifChecked.list-table-checkbox', '.checkbox [id^="checkbox_"]');
                $elements.off('ifUnchecked.list-table-checkbox', '.checkbox [id^="checkbox_"]');
                $elements.on('ifChecked.list-table-checkbox', '.checkbox [id^="checkbox_"]', execute);
                $elements.on('ifUnchecked.list-table-checkbox', '.checkbox [id^="checkbox_"]', execute);
            }
        }
    };

    mask = () => {
        const
            mask_number = jQuery('.mask_number'),
            mask_phone = jQuery('.mask_phone'),
            mask_cell = jQuery('.mask_cell'),
            mask_phones = jQuery('.mask_phones'),
            mask_cpf = jQuery('.mask_cpf'),
            mask_cnpj = jQuery('.mask_cnpj'),
            mask_document = jQuery('.mask_document'),
            mask_string_upper = jQuery('.mask_string_upper'),
            mask_complement = jQuery('.mask_complement'),
            mask_zip = jQuery('.mask_zip'),
            mask_money = jQuery('.mask_money'),
            mask_fraction_medium = jQuery('.mask_fraction_medium'),
            mask_fraction_full = jQuery('.mask_fraction_full'),
            mask_date = jQuery('.mask_date');

        if (!!mask_number && Boolean(mask_number.length)) {
            mask_number.off('keyup.mask_number');
            mask_number.on('keyup.mask_number', function () {
                jQuery(this).val(jQuery(this).val().classMask('number'));
            });
        }

        if (!!mask_phone && Boolean(mask_phone.length)) {
            mask_phone.off('keyup.mask_phone');
            mask_phone.on('keyup.mask_phone', function () {
                jQuery(this).val(jQuery(this).val().classMask('phone'));
            });
        }

        if (!!mask_cell && Boolean(mask_cell.length)) {
            mask_cell.off('keyup.mask_cell');
            mask_cell.on('keyup.mask_cell', function () {
                jQuery(this).val(jQuery(this).val().classMask('cell'));
            });
        }

        if (!!mask_phones && Boolean(mask_phones.length)) {
            mask_phones.off('keyup.mask_phones');
            mask_phones.on('keyup.mask_phones', function () {
                jQuery(this).val(jQuery(this).val().classMask('phoneAndCell'));
            });
        }

        if (!!mask_cpf && Boolean(mask_cpf.length)) {
            mask_cpf.off('keyup.mask_cpf');
            mask_cpf.on('keyup.mask_cpf', function () {
                jQuery(this).val(jQuery(this).val().classMask('cpf'));
            });
        }

        if (!!mask_cnpj && Boolean(mask_cnpj.length)) {
            mask_cnpj.off('keyup.mask_cnpj');
            mask_cnpj.on('keyup.mask_cnpj', function () {
                jQuery(this).val(jQuery(this).val().classMask('cnpj'));
            });
        }

        if (!!mask_document && Boolean(mask_document.length)) {
            mask_document.off('keyup.mask_document');
            mask_document.on('keyup.mask_document', function () {
                jQuery(this).val(jQuery(this).val().classMask('cpfAndCnpj'));
            });
        }

        if (!!mask_string_upper && Boolean(mask_string_upper.length)) {
            mask_string_upper.off('keyup.mask_string_upper');
            mask_string_upper.on('keyup.mask_string_upper', function () {
                jQuery(this).val(jQuery(this).val().classMask('string').toUpperCase());
            });
        }

        if (!!mask_complement && Boolean(mask_complement.length)) {
            mask_complement.off('keyup.mask_complement');
            mask_complement.on('keyup.mask_complement', function () {
                jQuery(this).val(jQuery(this).val().classMask('complement').toUpperCase());
            });
        }

        if (!!mask_zip && Boolean(mask_zip.length)) {
            mask_zip.off('keyup.mask_zip');
            mask_zip.on('keyup.mask_zip', function () {
                jQuery(this).val(jQuery(this).val().classMask('zip'));
            });
        }

        if (!!mask_money && Boolean(mask_money.length)) {
            mask_money.off('keyup.mask_money');
            mask_money.on('keyup.mask_money', function () {
                jQuery(this).val(jQuery(this).val().classMask('money'));
            });
        }

        if (!!mask_fraction_medium && Boolean(mask_fraction_medium.length)) {
            mask_fraction_medium.off('keyup.mask_fraction_medium');
            mask_fraction_medium.on('keyup.mask_fraction_medium', function () {
                jQuery(this).val(jQuery(this).val().classMask('fractionMedium'));
            });
        }

        if (!!mask_fraction_full && Boolean(mask_fraction_full.length)) {
            mask_fraction_full.off('keyup.mask_fraction_full');
            mask_fraction_full.on('keyup.mask_fraction_full', function () {
                jQuery(this).val(jQuery(this).val().classMask('fractionFull'));
            });
        }

        if (!!mask_date && Boolean(mask_date.length)) {
            mask_date.off('keyup.mask_date');
            mask_date.on('keyup.mask_date', function () {
                jQuery(this).val(jQuery(this).val().classMask('date'));
            });
        }
    };
}

const config = {
    default: {
        pace: false,
        sideMenu: false,
        menuMinimize: false,
        radioAndCheckbox: false,
        checkbox: false,
        mask: false
    }
};

export default (props) => (new HelpersTheme({...config.default, ...props}));
