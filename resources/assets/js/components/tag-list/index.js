import React from 'react'

export default React.createClass({

    getDefaultProps: function () {
        return {
            data: []
        }
    },

    render: function () {
        return (
            <div className="component-tag-list">
                <ul className="component-tag-list__list">
                {this.props.data.map(function (value) {
                    return (
                        <li className="component-tag-list__list__item" key={value.id}>
                            <a href={'#' + this.props.root + value.id}>{value.title}</a>
                        </li>
                    )
                }.bind(this))}
                </ul>
            </div>
        )
    }
});
