import HelpersController from './HelpersController';

import {
    HelpersClass,
    HelpersElement
} from './';

/**
 *
 */
class HelpersError extends HelpersController {

    /**
     *
     * @param props
     */
    constructor(props) {
        super(props);
        this.state = {
            errors: null
        };
    };

    /**
     *
     * @param event
     */
    onClear = (event) => {
        this.throttle('helpers-error', () => {
            let
                _id = HelpersElement(event).getId(),
                array = Boolean(_id) && _id.split('_');

            if (this.isArrayIf(array)) {
                this.clearError(array.join('.'));
            }
        }, 300);
    };

    /**
     *
     * @param target
     * @param callback
     */
    containElementError = (target, callback) => {
        let array = target.split('.');
        if (this.isArrayIf(array)) {
            let element = document.getElementById(array.join('_'));
            this.isElement(element) && callback(element, HelpersClass.hasClass(element, 'error'));
        }
    };

    /**
     *
     * @param target
     */
    createElementError = (target) => {
        this.containElementError(target, (element, contain) => {
            if (!contain) {
                let
                    small = document.createElement('small'),
                    text = document.createTextNode(this.getError(target));

                if (HelpersClass.hasClass(element, 'select2-hidden-accessible')) {
                    let select2 = element.parentNode.querySelector('.select2');
                    this.isElement(select2) && (element = select2);
                }

                HelpersClass.addClass(element, 'error');
                HelpersClass.addClasses(small, 'error', 'error-ellipsis');
                small.appendChild(text);
                element.parentNode.appendChild(small);

                this.addListener(element, 'keyup', `helpers-error-clear-keyup-${this.toSlug(HelpersElement(element).getId())}`, this.onClear);
                this.addListener(element, 'change', `helpers-error-clear-change-${this.toSlug(HelpersElement(element).getId())}`, this.onClear);
            }
        });
    };

    /**
     *
     * @param target
     */
    removeElementError = (target) => {
        this.containElementError(target, (element, contain) => {
            if (contain) {
                HelpersClass.removeClass(element, 'error');
                let
                    parent = element.parentNode,
                    children = this.elementToArray(parent.getElementsByTagName('small'));

                if (Boolean(children.length)) {
                    children.map((child) => {
                        parent.removeChild(child);
                    });
                }
            }
        });
    };

    /**
     *
     * @param errors
     * @param callback
     */
    setErrors = (errors, callback) => {
        this.setState({errors: null}, () => {
            if (!!errors) {
                for (let prefix in errors) {
                    if (errors.hasOwnProperty(prefix)) {
                        let fields = this.verifyField(errors, prefix, false, false);
                        if (!!fields) {
                            for (let field in fields) {
                                if (fields.hasOwnProperty(field)) {
                                    let
                                        array = this.verifyField(fields, field, false, false),
                                        value = (this.isArrayIf(array) ? [...array].shift() : false),
                                        target = `${prefix}.${field}`;

                                    this.mountObject(target, value, (object) => {
                                        this.setStates({errors: object}, () => {
                                            this.createElementError(target);
                                            (typeof(callback) === 'function') && callback(true);
                                        });
                                    });
                                }
                            }
                        }
                    }
                }
            }
        });
    };

    /**
     *
     * @param field
     * @returns {string}
     */
    getError = (field) => {
        return this.getState(`errors.${field}`);
    };

    /**
     *
     * @param field
     * @param callback
     */
    clearError = (field, callback) => {
        this.mountObject(field, null, (object) => {
            this.setStates({errors: object}, () => {
                this.removeElementError(field);
                (typeof(callback) === 'function') && callback(true);
            });
        });
    };
}

export default (new HelpersError());