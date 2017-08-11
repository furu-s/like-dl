module.exports = {
	entry: __dirname + '/public/src/index.jsx',
	output: {
		path: __dirname + '/js',
		filename: 'bundle.js'
	},
	module: {
		loaders: [//ローダー
			{
				test: /\.(js|jsx)?$/,
				exclude: /node_modules/,
				loader: 'babel-loader'
			}
		]
	},
	resolve: {
		// ここに登録した拡張子はimport時に付ける必要がない
		extensions: ['', '.js', '.jsx']
	}
}
