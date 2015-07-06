import $ from 'jquery'
import React from 'react'

export default React.createClass({

    render: function () {
        return (
            <div className="component-header">
                <div className="component-header__logo">HubMarks</div>
                <ul className="component-header__menu">
                    <li className="component-header__menu__item">
                        <a className="component-header__menu__item__link" href="/#/search">Search</a>
                    </li>
                    <li className="component-header__menu__item">
                        <a className="component-header__menu__item__link" href="/#/repositories">Repositories</a>
                    </li>
                </ul>
            </div>
        )
    }
});