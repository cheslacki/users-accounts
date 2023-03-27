import {Spinner} from 'spin.js';

import HelpersController from './HelpersController';

import {
    HelpersClass,
    HelpersStyle
} from './';

class HelpersSpinner extends HelpersController {

    /**
     *
     * @param props
     */
    constructor(props) {
        super(props);
        this.props = props;
        this.state = {
            attributes: {},
            listeners: {},
        };
    };

    /**
     *
     * @param element
     * @returns {Spinner}
     */
    create = (element) => {
        let height = element.offsetHeight;

        !Boolean(height) && (height = parseFloat(window.getComputedStyle(element).height));

        (height > 32) && (height *= 0.8);

        let
            radius = (height * 0.2),
            length = (radius * 0.6),
            width = (radius < 7 ? 2 : 3);


        let options = {
            ...this.props.options,
            length: length,
            width: width,
            radius: radius
        };

        if (!!element.innerHTML) {
            element.setAttribute('data-text', element.innerHTML);
            element.innerHTML = '';
        }

        HelpersClass.addClasses(element, 'disabled');

        return (new Spinner(options).spin(element));
    };

    start = () => {
        const {attributes} = this.state;
        let i = 0;

        if (Boolean(attributes.length)) {
            for (let key in attributes) {
                if (attributes.hasOwnProperty(key)) {
                    if (!this.state.listeners.hasOwnProperty(key)) {
                        let element = document.querySelector(`.${this.toSlug(key)}`);
                        this.isElement(element) && (this.state.listeners[key] = element);
                    }

                    if (this.state.listeners.hasOwnProperty(key)) {
                        if (attributes[key] && !this.isFunction(this.state.listeners[key], 'spin')) {
                            HelpersStyle.setStyle({
                                [key]: {
                                    position: 'relative',
                                    height: `${this.state.listeners[key].offsetHeight}px`,
                                    width: `${this.state.listeners[key].offsetWidth}px`
                                }
                            });
                            HelpersStyle.create('Spinner');
                            this.state.listeners[key] = this.create(this.state.listeners[key]);
                        } else if (!attributes[key] && this.isElement(this.state.listeners[key])) {
                            this.state.listeners[key].setAttribute('disabled', 'disabled');
                        }
                    }
                }

                if (!this.state.listeners.hasOwnProperty('length') && (attributes.length === ++i)) {
                    this.defineObject(this.state.listeners);
                }
            }
        }
    };

    stop = () => {
        const {listeners} = this.state;
        let i = 0;

        for (let key in listeners) {
            if (listeners.hasOwnProperty(key)) {
                if (this.isFunction(listeners[key], 'stop')) {
                    let element = listeners[key].el;
                    if (this.isElement(element)) {
                        let parent = element.parentNode;
                        parent.innerHTML = parent.getAttribute('data-text');
                        parent.removeAttribute('data-text');
                        HelpersClass.removeClass(parent, 'disabled');
                        HelpersStyle.remove('Spinner');
                        listeners[key].stop();
                    }
                } else if (this.isElement(listeners[key])) {
                    listeners[key].removeAttribute('disabled');
                }
            }

            if (listeners.length === ++i) {
                this.reset();
            }
        }
    };

    /**
     *
     * @param object
     */
    setAttributes = (object) => {
        this.reset();
        if (this.isObjectIf(object)) {
            for (let key in object) {
                if (object.hasOwnProperty(key)) {
                    (this.state.attributes.hasOwnProperty(key) && (object[key] === true)) && (this.state.attributes[key] = true);
                }
            }
        }
    };

    reset = () => {
        this.state.attributes = {...this.props.default};
        this.defineObject(this.state.attributes);
        this.state.listeners = {};
    };
}

/**
 *
 * @type {{default: {button_cancel: boolean, button_submit: boolean, button_update: boolean, button_delete: boolean, button_save: boolean, button_close: boolean, button_default: boolean, button_export: boolean, button_import: boolean, button_reply: boolean}, options: {length: number, width: number, radius: number, color: string, animation: string, className: string}}}
 */
const config = {
    default: {
        button_cancel: false,
        button_submit: false,
        button_update: false,
        button_delete: false,
        button_save: false,
        button_close: false,
        button_default: false,
        button_export: false,
        button_import: false,
        button_reply: false,
        button_erase: false
    },
    options: {
        length: 38,
        width: 17,
        radius: 45,
        color: '#FFFFFF',
        animation: 'spinner-line-fade-default',
        className: 'spinner animate__animated animate__faster animate__fadeIn'
    }
};

export default (new HelpersSpinner(config));