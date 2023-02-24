"use strict";

/**
 * External dependencies
 */
const path = require("path");
const { babel } = require("@rollup/plugin-babel");
const { nodeResolve } = require("@rollup/plugin-node-resolve");
const commonjs = require("@rollup/plugin-commonjs");
const multi = require("@rollup/plugin-multi-entry");
const replace = require("@rollup/plugin-replace");

/**
 * Internal dependencies
 */
const banner = require("./banner.js");

let fileDest = "hush-theme";
let globals = {
  jquery: "jQuery", // Ensure we use jQuery which is always available even in noConflict mode
};

const external = ["jquery"];

module.exports = {
  input: [path.resolve(__dirname, "../js/custom-javascript.js")],
  output: [
    {
      banner: banner(""),
      file: path.resolve(__dirname, `../../js/${fileDest}.js`),
      format: "iife",
      sourcemap: "inline",
    },
  ],
};
