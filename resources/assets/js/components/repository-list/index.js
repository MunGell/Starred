import $ from 'jquery'
import React from 'react'

export default React.createClass({

    getDefaultProps: function () {
        return {
            data: []
        }
    },

    render: function () {
        return (
            <div className="component-repository-list">
                <ul className="component-repository-list__list">
                {this.props.data.map(function (value) {
                    return (
                        <li className="component-repository-list__list__item" key={value.id}>
                            <a className="component-repository-list__list__item__link" href={'#' + this.props.root + value.id}>{value.full_name}</a>
                            <p className="component-repository-list__list__item__description" >{value.description}</p>
                        </li>
                    )
                }.bind(this))}
                </ul>
            </div>
        )
    }
});