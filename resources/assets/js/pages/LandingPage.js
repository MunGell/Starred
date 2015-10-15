import React from 'react'
import Style from 'react-postcss'
import Glyph from 'elemental/lib/components/Glyph'

import postcssPlugins from '../postcss-plugins'

export default React.createClass({

    style: function() {
        return `
            .page-landing {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                height: 100%;
                width: 100%;
                overflow: hidden;
                background-image: linear-gradient(45deg, #4fa49a, #4361c2);

                &__title {
                    text-align: center;

                    h1 {
                        margin: 0 0 10px 0;
                        color: #fff;
                        font-size: 42px;
                    }

                    h2 {
                        color: rgba(255, 255, 255, 0.75);
                        font-size: 18px;
                    }
                }

                &__features {
                    display: flex;
                    justify-content: space-around;
                    width: 80%;
                    max-width: 600px;
                    margin: 25px 0;
                }

                &__feature {
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    width: 100% / 3;
                    margin: 0 15px;

                    a, a:hover {
                        text-decoration: none;
                    }
                }

                &__feature-icon {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-width: 80px;
                    min-height: 80px;
                    border: solid 1px rgba(255, 255, 255, 0.5);
                    border-radius: 4px;
                    transform: rotate(45deg);
                    text-align: center;
                    transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;

                    &:hover {
                        background-color: rgba(255, 255, 255, 0.125);
                    }

                    .octicon {
                        color: #fff;
                        font-size: 42px;
                    }
                }

                &__feature-description {
                    padding: 10px;
                    margin: 10px 0 0 0;
                    color: #fff;
                    text-align: center;
                }

                &__cta {
                    text-align: center;
                }

                &__login-button {
                    padding: 10px 40px;
                    border: 1px solid #ffffff;
                    border-radius: 4px;
                    background: transparent;
                    color: #ffffff;
                    font-size: 16px;
                    text-transform: uppercase;
                    box-shadow: inset 0 0 0 1px #ffffff;
                    transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
                    text-decoration: none;

                    &:hover {
                        background-color: rgba(255, 255, 255, 0.125);
                        color: #ffffff;
                        text-decoration: none;
                    }
                }

            }
        `
    },

    render: function () {
        return (
            <div className="page-landing">
                <Style plugins={postcssPlugins}>
                    {this.style()}
                </Style>
                <div className="page-landing__title">
                    <h1>Starred by me</h1>
                    <h2>GitHub Repositories. Organised.</h2>
                </div>
                <div className="page-landing__features">
                    <div className="page-landing__feature">
                        <a href="/sync">
                            <div className="page-landing__feature-icon">
                                <Glyph icon="repo-sync" />
                            </div>
                        </a>
                        <h3 className="page-landing__feature-description">
                            Sync
                        </h3>
                    </div>
                    <div className="page-landing__feature">
                        <a href="/#/repositories">
                            <div className="page-landing__feature-icon">
                                <Glyph icon="tag" />
                            </div>
                        </a>
                        <h3 className="page-landing__feature-description">
                            Tag
                        </h3>
                    </div>
                    <div className="page-landing__feature">
                        <a href="/#/search">
                            <div className="page-landing__feature-icon">
                                <Glyph icon="search" />
                            </div>
                        </a>
                        <h3 className="page-landing__feature-description">
                            Find
                        </h3>
                    </div>
                </div>
                <div className="page-landing__cta">
                    <a href="/auth/login" className="page-landing__login-button">Organise</a>
                </div>
            </div>
        )
    }

});
