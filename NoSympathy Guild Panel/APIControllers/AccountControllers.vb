Imports APICore
Imports Models
Imports Newtonsoft.Json
Imports System.Collections.Specialized
Imports System.Web

Public Class AccountControllers
    Inherits BaseController
    Public Function GetAccount(access_token As String) As Account
        Dim endPoints = New Uri(String.Format(APICore.Gw2Endpoints.BaseUrl + APICore.Gw2Endpoints.Account + "?access_token={0}", access_token))

        Dim jsonres = GetApiDataByUriJson(endPoints)

        Dim ret = JsonConvert.DeserializeObject(Of Account)(jsonres)

        Return ret
    End Function

    Public Function GetAllMemberAccount() As List(Of Account)
        Dim endpoints = New Uri(String.Format(APICore.EngineEndpoints.BaseUrl + APICore.EngineEndpoints.GetMemberAccounts))

        Dim jsonres = GetApiDataByUriJson(endpoints)

        Dim ret = JsonConvert.DeserializeObject(Of List(Of Account))(jsonres)

        Return ret
    End Function

    Public Function SubmitMyData(name As String, apikey As String) As Boolean
        Dim endpoints = New Uri(String.Format(APICore.EngineEndpoints.BaseUrl + APICore.EngineEndpoints.PostMemberAccount))

        'Dim data = New NameValueCollection()
        'data.Add("name", name)
        'data.Add("apikey", apikey)

        Dim data = String.Format("name={0}&apikey={1}", HttpUtility.UrlEncode(name), HttpUtility.UrlEncode(apikey))


        Dim jsonres = GetApiDataByUriJson(endpoints, Enums.Method.PostData, data)
        Dim ret = JsonConvert.DeserializeObject(Of EngineResponse)(jsonres)

        If ret.Status = 1 Then
            Return True
        Else
            Return False
        End If
    End Function
End Class
