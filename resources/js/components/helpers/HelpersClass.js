/**
 * Created by Leonardo Cheslacki on 28/04/2022.
 */
import HelpersController from './HelpersController';

/**
 *
 */
class HelpersClass extends HelpersController {

    /**
     *
     * @param props
     */
    constructor(props) {
        super(props);
        this.state = {
            current: 0
        };
    };

    /**
     *
     * @param element
     * @returns {boolean|Array}
     */
    listClass = (element) => {
        let
            attribute = this.removeSpaceDuplicate(element.getAttribute('class')),
            array = Boolean(attribute) && attribute.split(' ');

        return Array.isArray(array) ? array : [];
    };

    /**
     *
     * @param element
     * @param className
     * @returns {boolean}
     */
    hasClass = (element, className) => {
        className = this.removeSpaceDuplicate(className);
        if (this.isElement(element) && Boolean(className)) {
            let array = this.listClass(element);
            return Boolean(array.length && this.inArray(array, className));
        }

        return false;
    };

    /**
     *
     * @param element
     * @param className
     */
    addClass = (element, className) => {
        if (!this.hasClass(element, className)) {
            className = this.removeSpaceDuplicate(className);
            if (Boolean(className)) {
                let array = this.listClass(element);
                Boolean(array.length) && array.push(className);
                element.setAttribute('class', (Boolean(array.length) ? array : [className]).join(' '));
            }
        }
    };

    /**
     *
     * @param element
     * @param classNames
     */
    addClasses = (element, ...classNames) => {
        if (this.isElement(element) && this.isArrayIf(classNames)) {
            for (let className in classNames) {
                if (classNames.hasOwnProperty(className)) {
                    this.addClass(element, classNames[className]);
                }
            }
        }
    };

    /**
     *
     * @param element
     * @param className
     */
    removeClass = (element, className) => {
        if (this.hasClass(element, className)) {
            className = this.removeSpaceDuplicate(className);
            if (Boolean(className)) {
                let array = this.listClass(element);
                if (Boolean(array.length)) {
                    array = array.filter((value) => {
                        return className !== value;
                    });
                    Boolean(array.length) ? element.setAttribute('class', array.join(' ')) : element.removeAttribute('class');
                }
            }

        }
    };

    /**
     *
     * @param element
     * @param classNameOut
     * @param classNameIn
     */
    changeClass = (element, classNameOut, classNameIn) => {
        this.removeClass(element, classNameOut);
        this.addClass(element, classNameIn);
    };

    /**
     *
     * @param element
     * @param classNames
     */
    removeClasses = (element, ...classNames) => {
        if (this.isElement(element) && this.isArrayIf(classNames)) {
            for (let className in classNames) {
                this.removeClass(element, classNames[className]);
            }
        }
    };
}

export default (new HelpersClass());
