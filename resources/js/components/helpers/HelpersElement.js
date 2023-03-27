/**
 * Created by Leonardo Cheslacki on 30/04/2022.
 */
import HelpersController from './HelpersController';

/**
 *
 */
class HelpersElement extends HelpersController {

    /**
     *
     * @param props
     */
    constructor(props) {
        super(props);
        this.state = {};
        this.$element = this.extractElement(props);
    };

    /**
     *
     * @param element
     * @returns {boolean}
     */
    extractElement = ({element}) => {
        return  (this.isElement(element) ? element : ((!!element && (typeof(element.target) !== 'undefined') && this.isElement(element.target)) && element.target));
    };

    getId = () => {
        let value = this.$element && this.$element.getAttribute('id');
        return Boolean(value) && value;
    };

    /**
     *
     * @param key
     * @returns {boolean|string}
     */
    getData = (key) => {
        let value = this.$element && (this.$element.getAttribute(`data-${key}`) || ((typeof(this.$element.parentNode) !== 'undefined') && this.$element.parentNode.getAttribute(`data-${key}`)));
        return Boolean(value) && value;
    };

    getInputs = () => {
        return this.$element && this.elementToArray(this.$element.querySelectorAll('input, select, textarea'));
    };

    /**
     *
     * @returns {boolean|*|string}
     */
    getName = (element) => {
        let value = (this.isElement(element) ? element.getAttribute('name') : (this.$element && this.$element.getAttribute('name')));
        return Boolean(value) && value;
    };

    /**
     *
     * @returns {boolean|*|string}
     */
    getValue = (element) => {
        let value = ((this.isElement(element) && (typeof(element.value) !== 'undefined')) ? element.value : ((this.$element && (typeof(this.$element) !== 'undefined')) && this.$element.value));
        return Boolean(value) ? value : '';
    };

    getMethod = () => {
        let value = this.$element && (this.$element.getAttribute('method') || this.getData('method'));
        return Boolean(value) ? value.toLowerCase() : null;
    };

    getAction = () => {
        let value = this.$element && (this.$element.getAttribute('action') || this.getData('action'));
        return Boolean(value) ? value.toLowerCase() : null;
    };

    /**
     *
     * @param element
     * @param type
     * @returns {*}
     */
    getType = (element, type) => {
        let string = this.isElement(element) && element.getAttribute('type');
        string = (Boolean(string) ? string : (typeof (element.type) !== 'undefined' && element.type));
        return ((typeof(type) !== 'undefined') ? (type === string) : string);
    };

    /**
     *
     * @param callback
     */
    mapInputs = (callback) => {
        let inputs = this.getInputs();
        if (Boolean(inputs.length)) {
            inputs.map((item) => {
                if (!this.getType(item, 'radio') || (this.getType(item, 'radio') && item.checked)) {
                    let
                        name = this.getName(item),
                        value = this.getValue(item);

                    this.getType(item, 'checkbox') && (value = item.checked ? value : 'off');

                    if(this.getType(item, 'select-multiple')){
                        let options = this.isElement(item) && this.elementToArray(item.options);

                        if(this.isArrayIf(options)){
                            value = [];
                            options.filter((option) => {
                                return (Boolean(option.selected) && Array.isArray(value)) && value.push(option.value);
                            });
                        }
                    }

                    Boolean(name) && callback(name, value);
                }
            });
        }
    };

    /**
     *
     * @param callback
     */
    getTarget = (callback) => {
        let
            method = this.getMethod(),
            action = this.getAction();

        (Boolean(method) && Boolean(action)) && callback(method, action);
    };
}

const config = {
    default: {
        SelectorRegex: /^(?:input|select|textarea|keygen)/i
    }
};

export default (props) => (new HelpersElement({element: props, config}));