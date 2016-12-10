'use strict';

require('style');

// import 'babel-polyfill';
import {foo} from './modules/module';


class App {
    constructor() {
        document.addEventListener('DOMContentLoaded', this.domReady.bind(this));
    }

    domReady(event) {
        console.log('DOM ready!');
        foo();
    }
}

export default new App();

if(module.hot) {
    module.hot.accept();
}