import $ from 'jquery'
import _ from 'lodash'
import React from 'react'

import Simple from './simple'
import LengthAware from './length-aware'

export default React.createClass({

    getDefaultProps: function () {
        return {
            type: 'simple',
            config: {},
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