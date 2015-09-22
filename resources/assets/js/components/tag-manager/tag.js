import React from 'react'
import Pill from 'elemental/lib/components/Pill'

export default React.createClass({

    getDefaultProps: function () {
        return {
            id: 0,
            title: '',
            onClear: function () {}
        }
    },

    _onClick: function() {
        debugger
    },

    _onClear: function() {
        this.props.onClear(this.props.id);
    },

    render: function () {
        return (
            <Pill label={this.props.label} type="default-inverted" onClear={this._onClear} onClick={this._onClick} />
        );
    }
});