import React from 'react'
import Style from 'react-postcss'
import postcssPlugins from '../../postcss-plugins'

export default React.createClass({

    style: function() {
        return `
            .component-header {
                display: flex;
                flex-direction: row;
                align-items: baseline;
                margin-bottom: 20px;

                &__logo {
                    margin-right: 20px;

                    &__link {
                        color: #000;
                        font-weight: bold;
                        font-size: 18px;

                        &:hover,
                        &:active,
                        &visited {
                            color: inherit;
                            text-decoration: none;
                        }
                    }
                }

                &__menu {
                    display: flex;
                    flex-direction: row;
                    margin: 0;
                    padding: 0;
                    list-style: none;

                    &__item {
                        margin-right: 20px;

                        &__link {

                        }
                    }
                }
            }
        `
    },

    render: function () {
        return (
            <div className="component-header">
                <Style plugins={postcssPlugins}>
                    {this.style()}
                </Style>
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
