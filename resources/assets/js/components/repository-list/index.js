import $ from 'jquery'
import React from 'react'

export default React.createClass({
    render: function () {
        return (
            <div className="component-repository-list">
                <ul className="component-repository-list__list">
                {this.props.data.map(function (value) {
                    return (
                        <li className="component-repository-list__list__item" key={value.id}>
                            <a href={'#' + this.props.root + value.id}>{value.full_name}</a>
                            <p>{value.description}</p>
                        </li>
                    )
                }.bind(this))}
                </ul>
            </div>
        )
    }
});