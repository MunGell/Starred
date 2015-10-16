import nested from 'postcss-nested'
import autoprefixer from 'autoprefixer'

export default [
    nested,
    autoprefixer({
        browsers: ['last 2 versions']
    })
]
