Imports Models
Imports Newtonsoft.Json

Public Class AccountControllers
    Inherits BaseController
    Public Function GetAccount(access_token As String) As Account
        Dim endPoints = New Uri(String.Format(APICore.Gw2Endpoints.BaseUrl + APICore.Gw2Endpoints.Account + "?access_token={0}", access_token))

        Dim jsonres = GetApiDataByUriJson(endPoints)

        Dim ret = JsonConvert.DeserializeObject(Of Account)(jsonres)

        Return ret
    End Function
End Class
