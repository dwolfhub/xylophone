"use strict";

var webpack = require("webpack"),
    path = require("path"),
    fs = require("fs");

var args = process.argv.slice(2).length ? process.argv.slice(2) : ['dev'];

if(args.length) {
    var env = path.join(__dirname, args[0] + ".js");
    fs.access(env, fs.F_OK, function(err){
        if(err){
            console.log('No env file for "' + args[0] + '" exists. Defaulting to "dev"');
            env = path.join(__dirname, "dev.js");
        }
        console.log("Running Webpack with env: " + env);
        webpack(require(env), function(){
            console.log("Webpack complete");
            process.exit(0);
        });
    });
} else {
    process.exit(1);
}
