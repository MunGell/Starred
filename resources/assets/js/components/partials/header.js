import React from 'react'

export default React.createClass({

    render: function () {
        return (
            <div className="component-header">
                <div className="component-header__logo">
                    <a className="component-header__logo__link" href="/#/repositories">Starred By Me</a>
                </div>
                <ul className="component-header__menu">
                    <li className="component-header__menu__item">
                        <a className="component-header__menu__item__link" href="/#/search">Search</a>
                    </li>
                    <li className="component-header__menu__item">
                        <a className="component-header__menu__item__link" href="/#/repositories">Repositories</a>
                    </li>
                    <li className="component-header__menu__item">
                        <a className="component-header__menu__item__link" href="/sync">Sync</a>
                    </li>
                </ul>
            </div>
        )
    }
});