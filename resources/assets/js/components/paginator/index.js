import React from 'react'

import Simple from './simple'
import LengthAware from './length-aware'

export default React.createClass({

    getDefaultProps: function () {
        return {
            type: 'simple',
            config: {
                currentPage: 0,
                from: 0,
                to: 0,
                perPage: 0,
                lastPage: 0
            },
            root: ''
        }
    },

    render: function () {
        var Component = Simple;
        if (this.props.type === 'length-aware') {
            Component = LengthAware;
        }
        return (
            <nav>
                <Component {...this.props}/>
            </nav>
        )
    }
});