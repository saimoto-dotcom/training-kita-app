module.exports = {
    entry: './resources/js/app.js',   // webpack の開始点
    output: {
      filename: 'app.js',             // 生成されるJSファイル
      path: __dirname + '/public/js', // 出力先
    },
    module: {
      rules: [
        {
          test: /\.scss$/,            // 対象は .scss ファイル
          use: ['style-loader', 'css-loader', 'sass-loader'], // コンパイル順序
        },
      ],
    },
  };
  