export function foo() {
    console.log('module loaded');
}

if(module.hot) {
    module.hot.accept();
}