var webpack = require('webpack');

module.exports = {
  entry: {
    app: './resources/assets/js/app.js',
    vendor: ['jquery']
  },
  output: {
    filename: '[name].js'
  },
  plugins: [
    new webpack.optimize.CommonsChunkPlugin({
      names: ['vendor']
    })
  ]
}
